-- Questions JavaScript Niveau Débutant (difficulté 1)
INSERT INTO questions (section_id, niveau_id, question, reponse1, reponse2, reponse3, reponse4, bonne_reponse) VALUES
(2, 4, 'Comment déclarer une variable en JavaScript ?', 'let variable;', 'var variable;', 'const variable;', 'variable;', 'let variable;'),
(2, 4, 'Quelle est la syntaxe pour un commentaire en JavaScript ?', '// commentaire', '/* commentaire */', '# commentaire', '-- commentaire', '// commentaire'),
(2, 4, 'Comment afficher un message dans la console ?', 'console.log("message");', 'print("message");', 'echo("message");', 'alert("message");', 'console.log("message");'),
(2, 4, 'Quelle est la syntaxe pour une boucle for ?', 'for(let i = 0; i < 10; i++)', 'for i in range(10)', 'for(i = 0; i < 10; i++)', 'loop(i = 0; i < 10; i++)', 'for(let i = 0; i < 10; i++)'),
(2, 4, 'Comment déclarer un tableau en JavaScript ?', 'let array = [];', 'let array = new Array();', 'let array = array();', 'let array = {};', 'let array = [];'),
(2, 4, 'Quelle méthode permet d''ajouter un élément à la fin d''un tableau ?', 'push()', 'append()', 'add()', 'insert()', 'push()'),
(2, 4, 'Comment accéder à la longueur d''un tableau ?', 'array.length', 'array.size', 'array.count', 'array.length()', 'array.length'),
(2, 4, 'Quelle est la syntaxe pour une condition if ?', 'if(condition) {}', 'if condition:', 'when(condition) {}', 'if condition then', 'if(condition) {}'),
(2, 4, 'Comment convertir une chaîne en nombre ?', 'parseInt()', 'toNumber()', 'convert()', 'number()', 'parseInt()'),
(2, 4, 'Quelle est la syntaxe pour une fonction ?', 'function maFonction() {}', 'def maFonction() {}', 'func maFonction() {}', 'void maFonction() {}', 'function maFonction() {}');

-- Questions JavaScript Niveau Intermédiaire (difficulté 2)
INSERT INTO questions (section_id, niveau_id, question, reponse1, reponse2, reponse3, reponse4, bonne_reponse) VALUES
(2, 5, 'Quelle est la syntaxe pour une fonction fléchée ?', '() => {}', 'function() => {}', '() -> {}', '=> () {}', '() => {}'),
(2, 5, 'Comment créer un objet en JavaScript ?', 'let obj = {};', 'let obj = new Object();', 'let obj = object();', 'let obj = createObject();', 'let obj = {};'),
(2, 5, 'Quelle méthode permet de filtrer un tableau ?', 'filter()', 'select()', 'where()', 'find()', 'filter()'),
(2, 5, 'Comment accéder à une propriété d''objet ?', 'obj.propriete', 'obj["propriete"]', 'obj->propriete', 'obj:propriete', 'obj.propriete'),
(2, 5, 'Quelle est la syntaxe pour une promesse ?', 'new Promise()', 'Promise.new()', 'createPromise()', 'makePromise()', 'new Promise()'),
(2, 5, 'Comment gérer les événements en JavaScript ?', 'addEventListener()', 'on()', 'bind()', 'attach()', 'addEventListener()'),
(2, 5, 'Quelle méthode permet de transformer un tableau ?', 'map()', 'transform()', 'convert()', 'change()', 'map()'),
(2, 5, 'Comment créer une classe en JavaScript ?', 'class MaClasse {}', 'def MaClasse {}', 'object MaClasse {}', 'struct MaClasse {}', 'class MaClasse {}'),
(2, 5, 'Quelle est la syntaxe pour l''importation de modules ?', 'import from', 'require', 'include', 'load', 'import from'),
(2, 5, 'Comment gérer les erreurs en JavaScript ?', 'try { } catch (error) { }', 'try { } except (error) { }', 'try { } error (error) { }', 'try { } handle (error) { }', 'try { } catch (error) { }');

-- Questions JavaScript Niveau Avancé (difficulté 3)
INSERT INTO questions (section_id, niveau_id, question, reponse1, reponse2, reponse3, reponse4, bonne_reponse) VALUES
(2, 6, 'Quelle est la syntaxe pour un générateur en JavaScript ?', 'function* generator() {}', 'generator function() {}', 'function generator() {}', 'function generate() {}', 'function* generator() {}'),
(2, 6, 'Comment utiliser les décorateurs en JavaScript ?', '@decorator', '#decorator', '$decorator', 'decorator()', '@decorator'),
(2, 6, 'Quelle est la syntaxe pour une classe privée ?', 'class #PrivateClass {}', 'private class PrivateClass {}', 'class private PrivateClass {}', 'class PrivateClass private {}', 'class #PrivateClass {}'),
(2, 6, 'Comment utiliser les Web Workers ?', 'new Worker()', 'Worker.new()', 'createWorker()', 'makeWorker()', 'new Worker()'),
(2, 6, 'Quelle est la syntaxe pour un proxy en JavaScript ?', 'new Proxy()', 'Proxy.new()', 'createProxy()', 'makeProxy()', 'new Proxy()'),
(2, 6, 'Comment utiliser les WeakMap ?', 'new WeakMap()', 'WeakMap.new()', 'createWeakMap()', 'makeWeakMap()', 'new WeakMap()'),
(2, 6, 'Quelle est la syntaxe pour un module ES6 ?', 'export default', 'module.exports', 'exports', 'export', 'export default'),
(2, 6, 'Comment utiliser les Symboles en JavaScript ?', 'Symbol()', 'new Symbol()', 'createSymbol()', 'makeSymbol()', 'Symbol()'),
(2, 6, 'Quelle est la syntaxe pour un itérateur personnalisé ?', '[Symbol.iterator]()', 'iterator()', 'next()', 'iterate()', '[Symbol.iterator]()'),
(2, 6, 'Comment utiliser les générateurs asynchrones ?', 'async function*', 'function* async', 'async generator', 'generator async', 'async function*'); 