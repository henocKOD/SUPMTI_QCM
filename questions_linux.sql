-- Questions Linux Niveau Débutant (difficulté 1)
INSERT INTO questions (section_id, niveau_id, question, reponse1, reponse2, reponse3, reponse4, bonne_reponse) VALUES
(3, 7, 'Quelle commande permet de lister les fichiers d''un répertoire ?', 'ls', 'dir', 'list', 'show', 'ls'),
(3, 7, 'Comment changer de répertoire en ligne de commande ?', 'cd', 'change', 'dir', 'move', 'cd'),
(3, 7, 'Quelle commande affiche le contenu d''un fichier ?', 'cat', 'type', 'show', 'display', 'cat'),
(3, 7, 'Comment créer un nouveau répertoire ?', 'mkdir', 'newdir', 'createdir', 'makedir', 'mkdir'),
(3, 7, 'Quelle commande permet de supprimer un fichier ?', 'rm', 'del', 'delete', 'remove', 'rm'),
(3, 7, 'Comment afficher le chemin du répertoire courant ?', 'pwd', 'path', 'current', 'where', 'pwd'),
(3, 7, 'Quelle commande permet de copier un fichier ?', 'cp', 'copy', 'duplicate', 'clone', 'cp'),
(3, 7, 'Comment déplacer un fichier ?', 'mv', 'move', 'transfer', 'relocate', 'mv'),
(3, 7, 'Quelle commande affiche l''aide d''une commande ?', 'man', 'help', 'info', 'doc', 'man'),
(3, 7, 'Comment afficher la date et l''heure ?', 'date', 'time', 'datetime', 'now', 'date');

-- Questions Linux Niveau Intermédiaire (difficulté 2)
INSERT INTO questions (section_id, niveau_id, question, reponse1, reponse2, reponse3, reponse4, bonne_reponse) VALUES
(3, 8, 'Quelle commande permet de rechercher des fichiers ?', 'find', 'search', 'locate', 'whereis', 'find'),
(3, 8, 'Comment afficher les processus en cours ?', 'ps', 'process', 'task', 'jobs', 'ps'),
(3, 8, 'Quelle commande permet de tuer un processus ?', 'kill', 'stop', 'end', 'terminate', 'kill'),
(3, 8, 'Comment compresser un fichier ?', 'gzip', 'zip', 'compress', 'pack', 'gzip'),
(3, 8, 'Quelle commande permet de décompresser un fichier ?', 'gunzip', 'unzip', 'extract', 'unpack', 'gunzip'),
(3, 8, 'Comment afficher l''espace disque disponible ?', 'df', 'disk', 'space', 'storage', 'df'),
(3, 8, 'Quelle commande permet de changer les permissions d''un fichier ?', 'chmod', 'perm', 'rights', 'access', 'chmod'),
(3, 8, 'Comment changer le propriétaire d''un fichier ?', 'chown', 'owner', 'possess', 'claim', 'chown'),
(3, 8, 'Quelle commande permet de filtrer le contenu d''un fichier ?', 'grep', 'filter', 'search', 'find', 'grep'),
(3, 8, 'Comment rediriger la sortie d''une commande vers un fichier ?', '>', '>>', '|', '&', '>');

-- Questions Linux Niveau Avancé (difficulté 3)
INSERT INTO questions (section_id, niveau_id, question, reponse1, reponse2, reponse3, reponse4, bonne_reponse) VALUES
(3, 9, 'Quelle commande permet de créer un lien symbolique ?', 'ln -s', 'symlink', 'link', 'shortcut', 'ln -s'),
(3, 9, 'Comment monter un système de fichiers ?', 'mount', 'attach', 'connect', 'link', 'mount'),
(3, 9, 'Quelle commande permet de gérer les services système ?', 'systemctl', 'service', 'daemon', 'process', 'systemctl'),
(3, 9, 'Comment créer un utilisateur ?', 'useradd', 'adduser', 'createuser', 'newuser', 'useradd'),
(3, 9, 'Quelle commande permet de gérer les groupes ?', 'groupadd', 'addgroup', 'creategroup', 'newgroup', 'groupadd'),
(3, 9, 'Comment configurer le pare-feu ?', 'iptables', 'firewall', 'security', 'filter', 'iptables'),
(3, 9, 'Quelle commande permet de gérer les paquets ?', 'apt', 'package', 'install', 'manager', 'apt'),
(3, 9, 'Comment créer un script shell ?', '#!/bin/bash', '#!/bin/sh', '#!/shell', '#!/script', '#!/bin/bash'),
(3, 9, 'Quelle commande permet de surveiller les logs système ?', 'journalctl', 'logwatch', 'logview', 'logmonitor', 'journalctl'),
(3, 9, 'Comment configurer le réseau ?', 'ip', 'network', 'netconfig', 'ifconfig', 'ip'); 