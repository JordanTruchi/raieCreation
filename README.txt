Install : 
front : 
npm i
npm run devserver
url utilisée : localhost:8080

back: importer le script mysql ce qui génère une mini base de données
url utilisée : localhost/raieCreation/back/api/

Arborescence du projet : 
Front office :
Technologie
Javascript avec VueJs
HTML, SCSS
Architecture mono-composant avec liaison vers le back end

Back-office : 
Technologie
Php, pas de framework
Api REST
Architecture MVC
Gestion des exceptions
Contact direct avec le front office

Fonctionnalités user : 
 - Visibilité des rendez-vous possible sur 1 semaine postérieur à la date actuelle
 - Prendre un rendez-vous
 - Création de compte
 - Gestion compte utilisateur
 - Gestion des rendez-vous personnels
 - Choix de la catégorie du rendez-vous
 - Navigation entre les différents jours.

Fonctionnalités admin :
 - Voir tous les rendez-vous
 - Gestions des utilisateurs
 - Gestion des rendez-vous
 - Gestion des catégories rendez-vous avec durée en fonction de la catégorie

Déploiement : 
Clood Azure dans une APP Service
RÉGION :
France Centre
SYSTÈME D’EXPLOITATION:
Linux
NIVEAU :
De base
INSTANCE :
2 coeurs, 3,5 gigo ram
