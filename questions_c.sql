-- Questions C Niveau Débutant (difficulté 1)
INSERT INTO questions (section_id, niveau_id, question, reponse1, reponse2, reponse3, reponse4, bonne_reponse) VALUES
(4, 10, 'Comment déclarer une variable entière en C ?', 'int variable;', 'integer variable;', 'number variable;', 'var variable;', 'int variable;'),
(4, 10, 'Quelle est la syntaxe pour un commentaire en C ?', '/* commentaire */', '// commentaire', '# commentaire', '-- commentaire', '/* commentaire */'),
(4, 10, 'Comment afficher du texte en C ?', 'printf("texte");', 'print("texte");', 'echo("texte");', 'cout << "texte";', 'printf("texte");'),
(4, 10, 'Quelle est la syntaxe pour une boucle for ?', 'for(int i = 0; i < 10; i++)', 'for i in range(10)', 'for(i = 0; i < 10; i++)', 'loop(i = 0; i < 10; i++)', 'for(int i = 0; i < 10; i++)'),
(4, 10, 'Comment déclarer un tableau en C ?', 'int array[10];', 'array[10] int;', 'int[] array;', 'array int[10];', 'int array[10];'),
(4, 10, 'Quelle est la syntaxe pour une condition if ?', 'if(condition) {}', 'if condition:', 'when(condition) {}', 'if condition then', 'if(condition) {}'),
(4, 10, 'Comment déclarer une fonction en C ?', 'int maFonction() {}', 'function maFonction() {}', 'def maFonction() {}', 'void maFonction() {}', 'int maFonction() {}'),
(4, 10, 'Quelle est la syntaxe pour un pointeur ?', 'int* ptr;', 'pointer int ptr;', 'ptr int*;', 'int ptr*;', 'int* ptr;'),
(4, 10, 'Comment inclure une bibliothèque en C ?', '#include <stdio.h>', 'import stdio.h', 'require stdio.h', 'using stdio.h', '#include <stdio.h>'),
(4, 10, 'Quelle est la syntaxe pour une structure ?', 'struct MaStruct {};', 'structure MaStruct {}', 'class MaStruct {}', 'object MaStruct {}', 'struct MaStruct {};');

-- Questions C Niveau Intermédiaire (difficulté 2)
INSERT INTO questions (section_id, niveau_id, question, reponse1, reponse2, reponse3, reponse4, bonne_reponse) VALUES
(4, 11, 'Comment allouer de la mémoire dynamiquement ?', 'malloc()', 'new', 'allocate()', 'create()', 'malloc()'),
(4, 11, 'Quelle est la syntaxe pour un pointeur de fonction ?', 'int (*ptr)();', 'function* ptr;', 'ptr function;', 'int ptr*();', 'int (*ptr)();'),
(4, 11, 'Comment utiliser les énumérations en C ?', 'enum {A, B, C};', 'enumeration {A, B, C};', 'enum class {A, B, C};', 'enum type {A, B, C};', 'enum {A, B, C};'),
(4, 11, 'Quelle est la syntaxe pour un union ?', 'union MonUnion {};', 'union type MonUnion {}', 'union class MonUnion {}', 'union struct MonUnion {}', 'union MonUnion {};'),
(4, 11, 'Comment utiliser les macros en C ?', '#define MACRO', 'macro MACRO', 'define MACRO', 'const MACRO', '#define MACRO'),
(4, 11, 'Quelle est la syntaxe pour un typedef ?', 'typedef int MonType;', 'type MonType int;', 'define type MonType int;', 'new type MonType int;', 'typedef int MonType;'),
(4, 11, 'Comment gérer les erreurs en C ?', 'errno', 'error', 'exception', 'try-catch', 'errno'),
(4, 11, 'Quelle est la syntaxe pour un bitfield ?', 'struct { int a:1; };', 'struct { bit a:1; };', 'struct { field a:1; };', 'struct { flag a:1; };', 'struct { int a:1; };'),
(4, 11, 'Comment utiliser les fichiers en C ?', 'FILE*', 'file', 'stream', 'handle', 'FILE*'),
(4, 11, 'Quelle est la syntaxe pour un pointeur constant ?', 'const int* ptr;', 'int const* ptr;', 'int* const ptr;', 'const ptr int*;', 'const int* ptr;');

-- Questions C Niveau Avancé (difficulté 3)
INSERT INTO questions (section_id, niveau_id, question, reponse1, reponse2, reponse3, reponse4, bonne_reponse) VALUES
(4, 12, 'Comment utiliser les threads en C ?', 'pthread_create()', 'thread_create()', 'create_thread()', 'new_thread()', 'pthread_create()'),
(4, 12, 'Quelle est la syntaxe pour un pointeur de pointeur ?', 'int** ptr;', 'pointer to pointer int ptr;', 'int ptr**;', 'int* ptr*;', 'int** ptr;'),
(4, 12, 'Comment utiliser les signaux en C ?', 'signal()', 'sigaction()', 'sig_handler()', 'handle_signal()', 'signal()'),
(4, 12, 'Quelle est la syntaxe pour un pointeur de fonction avec paramètres ?', 'int (*ptr)(int, char);', 'function* ptr(int, char);', 'ptr function(int, char);', 'int ptr*(int, char);', 'int (*ptr)(int, char);'),
(4, 12, 'Comment utiliser les sockets en C ?', 'socket()', 'create_socket()', 'new_socket()', 'open_socket()', 'socket()'),
(4, 12, 'Quelle est la syntaxe pour un pointeur de structure ?', 'struct MaStruct* ptr;', 'struct* MaStruct ptr;', 'ptr struct MaStruct*;', 'MaStruct struct* ptr;', 'struct MaStruct* ptr;'),
(4, 12, 'Comment utiliser les mutex en C ?', 'pthread_mutex_t', 'mutex_t', 'lock_t', 'semaphore_t', 'pthread_mutex_t'),
(4, 12, 'Quelle est la syntaxe pour un pointeur de tableau ?', 'int (*ptr)[10];', 'array* int ptr[10];', 'int ptr*[10];', 'int* ptr[10];', 'int (*ptr)[10];'),
(4, 12, 'Comment utiliser les pipes en C ?', 'pipe()', 'create_pipe()', 'new_pipe()', 'open_pipe()', 'pipe()'),
(4, 12, 'Quelle est la syntaxe pour un pointeur de fonction de callback ?', 'void (*callback)(void*);', 'callback function(void*);', 'function* callback(void*);', 'void callback*(void*);', 'void (*callback)(void*);'); 