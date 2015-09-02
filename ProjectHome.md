# Filezilla server web administration #

The main goal is to provide a PHP API which allows to administer your filezilla FTP Server, from your webserver, or from PHP CLI.

## Principe ##
Filezilla server uses a XML file to store its whole configuration (settings, users and groups).
You can then edit this file and call : "path/to/filezilla server/filezilla server.exe /reload-config" to reload configuration.

See http://wiki.filezilla-project.org/Command-line_arguments_(Server)

A web UI will come in a second time. A preview :
<img src='http://ivanramirez.fr/projects/fzwebadmin/img/fzwebadmin_preview.jpg' />