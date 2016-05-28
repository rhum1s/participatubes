# -*- coding: utf-8 -*-
# Participatubes - Script d'installation 
# Logo crée avec figlet

class Cfg():
    def __init__(self, cfg_file, debug=False):
        """
        Lecture d'un fichier de configuation type
        '
        [Geoserver]
        host = localhost
        lgn = ***
        pwd = *** 
        bdd = postgres
        port = 5432         
        '
        """  
        if os.path.isfile(cfg_file):
            self.cfg_file = cfg_file
            self.config = ConfigParser.ConfigParser()
            self.config.read(cfg_file)
            self.debug = debug
            
            # Geoserver config
            self.host = self.ConfigSectionMap(self.config, "Geoserver")['host']  
            self.lgn = self.ConfigSectionMap(self.config, "Geoserver")['lgn'] 
            self.pwd = self.ConfigSectionMap(self.config, "Geoserver")['pwd']  

            # PostgreSQL config
            self.pg_host = self.ConfigSectionMap(self.config, "Connection")['host']  
            self.pg_lgn = self.ConfigSectionMap(self.config, "Connection")['lgn'] 
            self.pg_pwd = self.ConfigSectionMap(self.config, "Connection")['pwd']  
            self.pg_bdd = "participatubes"  
            self.pg_port = self.ConfigSectionMap(self.config, "Connection")['port']  
            
        else:
            self.error("%s is doesn't exists." % cfg_file, exit=True)
               
        if self.debug is True:
            print "Fichier de configuration lu."

    def ConfigSectionMap(self, config_object, section):
        """
        Mapping des sections d'un fichier de config.
        """
        section_dict = {}
        options = config_object.options(section)
        
        for option in options:
            try:
                section_dict[option] = config_object.get(section, option)
                if section_dict[option] == -1:
                    self.warning("skip: %s" % option)
            except:
                self.warning("exception on %s!" % option)
                section_dict[option] = None
        
        return section_dict             
  
class GsConn():
    def __init__(self, host, login, password, debug=False):    
        """
        Geoserver connection
        """        
        self.host = host
        self.login = login
        self.password = password
        self.debug = debug
        
        # Connect to server
        self.cat = Catalog("http://%s/geoserver/rest" % host, login, password)   
        if self.debug is True:
            print "Connected to geoserver"
    
    def crate_workspace(self, name, uri, overwrite=False):
        """
        Creates a workspace
        :param name: Workspace name.
        :param overwrite: If True, delete existing workspace.
        :return: None
        """   
        workspaces = [workspace.name for workspace in self.cat.get_workspaces()]
        
        if name in workspaces and overwrite is True:
            # ws2del = self.cat.get_workspace(name)
            # self.cat.delete(ws2del, purge=True, recurse=True)
            return None  # NOTE: If we delete the workspace then all associated layers are lost.
        elif name in workspaces and overwrite is False:
            print "ERROR: Workspace %s already exists (use overwrite=True)." % name 
        
        self.cat.create_workspace(name, uri)
        if self.debug is True:
            print "Workspace %s available." % name
             
        ws = self.cat.get_workspace(name)
        ws.enabled = True
        
    def create_pg_store(self, name, workspace, host, port, login, password, 
        dbname, schema, overwrite=False):
        """
        Creates datastore.
        :param name: Name of the datastore.
        :param workspace: Name of the workspace to use.
        :param overwrite: If True replace datastore.
        :return: None
        """
        stores = [store.name for store in self.cat.get_stores()]

        if name in stores and overwrite is True:
            # st2del = self.cat.get_store(name)
            # self.cat.delete(st2del, purge=True, recurse=True)
            # self.cat.reload()   
            return None  # NOTE: If we delete store, every layers associated with are lost.
        elif name in stores and overwrite is False:
            print "ERROR: Store %s already exists (use overwrite=True)." % name 
        
        ds = self.cat.create_datastore(name, workspace)
        ds.connection_parameters.update(host=host, port=port, user=login, 
            passwd=password, dbtype='postgis', database=dbname, schema=schema)
        self.cat.save(ds)
        
        ds = self.cat.get_store(name)
        if ds.enabled is False:
            print "ERROR: Geoserver store %s not enabled" % name
        
        if self.debug is True:
            print "Datastore %s created." % name
        
    def publish_pg_layer(self, layer_table, layer_name, store, srid, overwrite=True):
        """
        """                
        existing_lyr = self.cat.get_layer("participatubes:%s" % layer_table)
        if existing_lyr is not None:
            print "Layer participatubes:%s already exists, deleting it." % layer_table
            self.cat.delete(existing_lyr) 
            self.cat.reload()
            
        ds = self.cat.get_store(store)
        ft = self.cat.publish_featuretype(layer_table, ds, 'EPSG:%s' % srid, srs='EPSG:4326')  
        ft.projection_policy = "REPROJECT_TO_DECLARED"
        ft.title = layer_name
        self.cat.save(ft) 
        
        if ft.enabled is False:
            print "ERROR: Layer %s %s %s is not enabled." (ft.workspace.name, ft.store.name, ft.title)    
        
        if self.debug is True:
            print "Layer %s>%s>%s published." % (ft.workspace.name, ft.store.name, ft.title)

    def create_style_from_sld(self, style_name, sld_file, workspace, overwrite=True):
        """
        """
        if self.cat.get_style(style_name) is not None:
            print "Style %s already exists, deleting it." % style_name
            style2del = self.cat.get_style(style_name)
            self.cat.delete(style2del) 
        
        self.cat.create_style(style_name, open(sld_file).read(), overwrite=overwrite) # FIXME: if ", workspace=workspace" specified can't delete style

        if self.debug is True:
            print "Style %s created in Geoserver" % style_name

    def apply_style_to_layer(self, layer_name, style_name):
        """
        Apply a geoserver styler to a layer
        """       
        gs_layer = self.cat.get_layer(layer_name)
        gs_style = self.cat.get_style(style_name)
        
        # FIXME: Which works better? 
        # gs_layer.default_style = gs_style / gs_layer._set_default_style(gs_style)  
        # FIXME: Maybe indicate workspace when saving style then name the style as "workspace:style"
        gs_layer._set_default_style(gs_style)  
        self.cat.save(gs_layer)   

        if self.debug is True:
            print "Style applied to %s" % layer_name
            
def intro():
    """
    Demande si l'utilisateur veut vraiment installer 
    une nouvelle version de l'application.
    """

    continuer = raw_input(""" 
     ____            _   _      _             _         _  
    |  _ \ __ _ _ __| |_(_) ___(_)_ __   __ _| |_ _   _| |__   ___  ___ 
    | |_) / _` | '__| __| |/ __| | '_ \ / _` | __| | | | '_ \ / _ \/ __|  
    |  __/ (_| | |  | |_| | (__| | |_) | (_| | |_| |_| | |_) |  __/\__ \ 
    |_|   \__,_|_|   \__|_|\___|_| .__/ \__,_|\__|\__,_|_.__/ \___||___/ 
                                 |_|
                                  
    Installer participatubes avec le fichier de configuration example.cfg?
    ATTENTION: L'installation supprimera une éventuelle base de données éxistante.
    [o/n/Ctrl+c]
    """)

    if continuer not in ("o"):
        sys.exit()
    else:
        print "Démarrage de l'installation ..."    
    
def creation_base_de_donnees():
    """
    Création de la base de données et 
    du schéma de campagne template.
    """
    # Connexion bdd par défaut du serveur PostgreSQL et création base template
    db = PgDb("example.cfg", debug=True)
    db.maintenance("""
    SELECT pg_terminate_backend(procpid) 
    FROM pg_stat_activity 
    WHERE datname='participatubes';
    """)
    db.maintenance("""
    DROP DATABASE IF EXISTS participatubes;
    """)
    db.maintenance("""
    CREATE DATABASE participatubes
    WITH ENCODING='UTF8'
    OWNER=%s
    TEMPLATE=template_postgis
    CONNECTION LIMIT=-1;
    """ % db.lgn)
    db.disconnect()

    print "Base de données participatubes crée sur %s" % db.host

    # Création des objets de la base template
    racine = os.path.dirname(os.path.realpath(__file__)).replace("/", "\\/")

    out_file = open("template_db.sql.mef", "w")
    sub = subprocess.call(["sed", "s/::RACINE::/%s/g" % racine, "template_db.sql"], stdout=out_file)
    out_file.close()

    bashCommand = "psql -U %s -d participatubes -f template_db.sql.mef" % cfg.pg_lgn
    process = subprocess.Popen(bashCommand.split(), stdout=subprocess.PIPE)
    output = process.communicate()[0]

    print "Campagne c_template crée dans %s" % db.bdd

def installation_web_application():
    """
    Lien de la web application dans le dossier /var/www/
    """

    # Suppression du dossier participatubes dans /var/www/ si existant
    if os.path.isdir("/var/www/participatubes") is True:
        process = subprocess.Popen("rm -r /var/www/participatubes", shell=True, stdout=subprocess.PIPE, stderr=subprocess.PIPE) 
        out,err = process.communicate()  
        
    # Création d'un nouveau dossier participatubes dans /var/www/
    process = subprocess.Popen("mkdir /var/www/participatubes", shell=True, stdout=subprocess.PIPE, stderr=subprocess.PIPE) 
    out,err = process.communicate()  
    
    # Lien symbolic dans le nouveau dossier renvoyant vers les sources web application
    racine = os.path.dirname(os.path.realpath(__file__)).replace("/", "\\/")
    racine_webapp = "%s/web_app" % racine.replace("\\", "").replace(r'/install', "")   

    bashCommand = "ln -s %s /var/www/participatubes/" % racine_webapp
    process = subprocess.Popen(bashCommand, shell=True, stdout=subprocess.PIPE, stderr=subprocess.PIPE)    
                
    print "Web application installée dans /var/www/participatubes"

def parametrage_geoserver():
    """
    """
    # Connexion à geoserver
    gsconn = GsConn(cfg.host, cfg.lgn, cfg.pwd, debug=True)
    # Create workspace corresponding to map name
    gsconn.crate_workspace("participatubes", "http://%s/participatubes" % cfg.pg_host, overwrite=True)
    # Create as many stores as needed (according to data sources)
    gsconn.create_pg_store("c_template", "participatubes", cfg.pg_host, 
                cfg.pg_port, cfg.pg_lgn, cfg.pg_pwd, cfg.pg_bdd, "c_template", overwrite=True)
    
    print "FIXME: Ne fonctionne pas la première fois si connexion Geoserver tuée en créant bdd."
    # Publish layers and export sld
    gsconn.publish_pg_layer("tubes_mef", "Tubes", "c_template", 2154, overwrite=True)

    gsconn = None      
    
    
# Chargement des modules
import sys
import os
import ConfigParser
import subprocess
from geoserver.catalog import Catalog

# On vérifie que le script soit lancé depuis le dossier d'installation
if os.path.isfile("template_db.sql") is False:
    print "ERROR: Le script install.py doit-être lancé depuis src/intall/."
    sys.exit()
        
# Import des modules spéciaux
sys.path.append("../../scriptTools")
from pypg import PgDb

# Installation
cfg = Cfg(r"example.cfg", debug=True)
    
intro()
creation_base_de_donnees()
installation_web_application()
parametrage_geoserver()
  
# Fin de l'installation
print "Installation terminée. Vous pouvez utiliser participatubes sur http://localhost/participatubes/web_app"




