# LPSIL-Projet-web

## Sujet

Imaginez que la Direction Régionale des Affaires Culturelles vous demande de développer un site WEB pour connaitre la liste des Musées et des Monuments Historiques de Franche-Comté.

Pour cela, on vous fournit 2 fichiers SQL.
Vous devrez dans un premier temps intégrer ces tables dans une base de données MySQL.

Vous devrez ensuite écrire un site WEB qui soit "responsive", en utilisant le framework Bootstrap, qui soit capable de questionner cette base de données pour retrouver des lieux, par une partie du nom, par commune, par catégorie (à vous d'imaginer les critère de recherche les plus pertinents)

Vous devrez positionner les résultats, en fonction de la latitude et de la longitude, sur une carte en utilisant l'API de Google Maps.
A la position du lieu, vous placerez sur la carte le pictogramme correspondant à sa catégorie.


## Dépendances

Ce projet utilise Bootstrap version 5 et Google Maps pour fonctionner.
Il repose sur un server web utilisant PHP (7.4 ou plus récent) et d'une base de données MySQL (ou MariaDB).

Attention, l'utilisation des scripts SQL fournis est **primordial**, ceux-ci ayant été modifié par rapport au sujet pour des raisons de problème d'encodage et donc d'utilisation. Merci de votre compréhension.