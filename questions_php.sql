-- Questions PHP Niveau Débutant (difficulté 1)
INSERT INTO questions (section_id, niveau_id, question, reponse1, reponse2, reponse3, reponse4, bonne_reponse) VALUES
(1, 1, 'Quelle est la syntaxe correcte pour déclarer une variable en PHP ?', '$variable', 'var variable', 'let variable', 'const variable', '$variable'),
(1, 1, 'Comment afficher du texte en PHP ?', 'echo "texte";', 'print("texte");', 'console.log("texte");', 'printf("texte");', 'echo "texte";'),
(1, 1, 'Quel est le symbole pour concaténer des chaînes en PHP ?', '.', '+', '&', '|', '.'),
(1, 1, 'Comment déclarer un tableau en PHP ?', '$array = [];', '$array = array();', '$array = new Array();', '$array = {};', '$array = [];'),
(1, 1, 'Quelle fonction permet de compter le nombre d''éléments dans un tableau ?', 'count()', 'length()', 'size()', 'sizeof()', 'count()'),
(1, 1, 'Comment accéder au premier élément d''un tableau ?', '$array[0]', '$array[1]', '$array.first', '$array->first', '$array[0]'),
(1, 1, 'Quelle est la syntaxe correcte pour une boucle foreach en PHP ?', 'foreach($array as $value)', 'for($array as $value)', 'loop($array as $value)', 'each($array as $value)', 'foreach($array as $value)'),
(1, 1, 'Comment vérifier si une variable existe en PHP ?', 'isset($variable)', 'exists($variable)', 'defined($variable)', 'has($variable)', 'isset($variable)'),
(1, 1, 'Quelle fonction permet de convertir une chaîne en nombre entier ?', 'intval()', 'parseInt()', 'toInt()', 'integer()', 'intval()'),
(1, 1, 'Comment inclure un fichier PHP dans un autre ?', 'include ''fichier.php'';', 'import ''fichier.php'';', 'require ''fichier.php'';', 'load ''fichier.php'';', 'include ''fichier.php'';');

-- Questions PHP Niveau Intermédiaire (difficulté 2)
INSERT INTO questions (section_id, niveau_id, question, reponse1, reponse2, reponse3, reponse4, bonne_reponse) VALUES
(1, 2, 'Quelle est la syntaxe correcte pour déclarer une fonction en PHP ?', 'function maFonction() {}', 'def maFonction() {}', 'func maFonction() {}', 'void maFonction() {}', 'function maFonction() {}'),
(1, 2, 'Comment accéder aux paramètres GET dans PHP ?', '$_GET[''param'']', '$GET[''param'']', 'get(''param'')', 'request.get(''param'')', '$_GET[''param'']'),
(1, 2, 'Quelle fonction permet de vérifier le type d''une variable ?', 'gettype()', 'typeof()', 'type()', 'checktype()', 'gettype()'),
(1, 2, 'Comment créer une session en PHP ?', 'session_start();', 'start_session();', 'create_session();', 'init_session();', 'session_start();'),
(1, 2, 'Quelle est la syntaxe pour déclarer une constante en PHP ?', 'define(''NOM'', ''valeur'');', 'const NOM = ''valeur'';', 'constant NOM = ''valeur'';', 'set NOM = ''valeur'';', 'define(''NOM'', ''valeur'');'),
(1, 2, 'Comment gérer les erreurs en PHP ?', 'try { } catch (Exception $e) { }', 'try { } except (Exception $e) { }', 'try { } error (Exception $e) { }', 'try { } handle (Exception $e) { }', 'try { } catch (Exception $e) { }'),
(1, 2, 'Quelle fonction permet de formater une date en PHP ?', 'date()', 'format_date()', 'time_format()', 'datetime()', 'date()'),
(1, 2, 'Comment lire le contenu d''un fichier en PHP ?', 'file_get_contents()', 'read_file()', 'load_file()', 'get_file()', 'file_get_contents()'),
(1, 2, 'Quelle est la syntaxe pour une requête SQL préparée en PHP ?', '$stmt = $pdo->prepare($sql);', '$stmt = $pdo->query($sql);', '$stmt = $pdo->execute($sql);', '$stmt = $pdo->run($sql);', '$stmt = $pdo->prepare($sql);'),
(1, 2, 'Comment vérifier si un fichier existe en PHP ?', 'file_exists()', 'exists()', 'is_file()', 'check_file()', 'file_exists()');

-- Questions PHP Niveau Avancé (difficulté 3)
INSERT INTO questions (section_id, niveau_id, question, reponse1, reponse2, reponse3, reponse4, bonne_reponse) VALUES
(1, 3, 'Quelle est la syntaxe pour déclarer une classe en PHP ?', 'class MaClasse {}', 'def MaClasse {}', 'object MaClasse {}', 'struct MaClasse {}', 'class MaClasse {}'),
(1, 3, 'Comment déclarer une propriété statique dans une classe PHP ?', 'static $variable;', 'var static $variable;', 'const $variable;', 'public static $variable;', 'static $variable;'),
(1, 3, 'Quelle est la syntaxe pour l''héritage en PHP ?', 'class Enfant extends Parent', 'class Enfant : Parent', 'class Enfant inherits Parent', 'class Enfant implements Parent', 'class Enfant extends Parent'),
(1, 3, 'Comment déclarer une interface en PHP ?', 'interface MonInterface {}', 'interface class MonInterface {}', 'abstract interface MonInterface {}', 'trait MonInterface {}', 'interface MonInterface {}'),
(1, 3, 'Quelle est la syntaxe pour un trait en PHP ?', 'trait MonTrait {}', 'mixin MonTrait {}', 'module MonTrait {}', 'component MonTrait {}', 'trait MonTrait {}'),
(1, 3, 'Comment utiliser un namespace en PHP ?', 'namespace MonNamespace;', 'use namespace MonNamespace;', 'import MonNamespace;', 'require namespace MonNamespace;', 'namespace MonNamespace;'),
(1, 3, 'Quelle est la syntaxe pour une méthode magique en PHP ?', '__construct()', 'constructor()', 'init()', 'create()', '__construct()'),
(1, 3, 'Comment implémenter une méthode abstraite en PHP ?', 'abstract function maMethode();', 'virtual function maMethode();', 'interface function maMethode();', 'abstract public function maMethode();', 'abstract function maMethode();'),
(1, 3, 'Quelle est la syntaxe pour une closure en PHP ?', 'function() use ($variable) {}', '() => {}', 'function($variable) {}', 'closure($variable) {}', 'function() use ($variable) {}'),
(1, 3, 'Comment gérer les exceptions personnalisées en PHP ?', 'class MonException extends Exception {}', 'class MonException implements Exception {}', 'class MonException : Exception {}', 'class MonException throws Exception {}', 'class MonException extends Exception {}'); 