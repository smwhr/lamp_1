Exercices LAMP
==============

Le corrigé est mis en ligne sur ce repository au fur et à mesure du cours.

Ex 0 : Jeu de plus ou moins : le jeu doit fonctionner

Ex 1 : Compter les coups

Ex 2 : Se souvenir du meilleur coup

Ex 2bis : Permettre au joueur de réinitialiser son meilleur score

Ex 3 : Opposer une page de login. Effectuer les redirections automatiques suivante :
 - Je ne suis pas connecté, je suis toujours renvoyé vers /login.php
 - Je suis connecté : on ne me redemande pas mes identifiants

Ex 4 : créer une table "users" contenant les champs suivants
 - id (INT, PRIMARY, AUTO_INCREMENT)
 - login (VARCHAR 255)
 - password (VARCHAR 40)
 - best_score (INT, NULL)

Ex 5 : Améliorer le login de l'Ex 3 en remplaçant la source de donnée par la base

Ex 5bis : Permettre à la personne de se déconnecter

Ex 5ter : Sécurisez le stockage du mot de passe 

Ex 6 : Sauvegardez le meilleur score en base

Ex 7 : Afficher un leaderboard des meilleurs scores

Ex 8 : Sauvegardez la partie du joueur en cours (si il se déconnecte puis se reconnecte, il reprend exactement là où il en était)

Ex 8bis : Garder l'historique des parties terminées (on sauvegardera le nombre trouvé, le nombre de coups ainsi que la date de cette partie)

Ex 9 : Architecture : réorganisez votre code afin d'avoir le minimum de duplication.

Ex 10 : Déployez votre application en ligne.

Ex 11 : Remplacez le moteur de "plus ou moins" par un moteur de "black jack"

Ex 12 : Refactoring : Assurez-vous que tout votre code adopte bien une organisation en Model View Controller