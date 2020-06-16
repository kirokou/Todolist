[![Codacy Badge](https://app.codacy.com/project/badge/Grade/edb47d287475424a956fb035842a6081)](https://www.codacy.com/manual/borgine/Todolist?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=kirokou/Todolist&amp;utm_campaign=Badge_Grade)

[![Maintainability](https://api.codeclimate.com/v1/badges/1bc6081ee8a7a35f76fe/maintainability)](https://codeclimate.com/github/kirokou/Todolist/maintainability)

[![Build Status](https://travis-ci.com/kirokou/Todolist.svg?branch=master)](https://travis-ci.com/kirokou/Todolist)

# HOW INSTALL THIS PROJECT

## Required and technical environment
- Language PHP >=  7.2.30
- Database MySQL >=  5.7.25
- Web Server
- Symfony
- Composer

## Bundles
- PHPUnit
- LiipTestFixturesBundle
- Twig

## Step 1: clone the project
        git clone https://github.com/kirokou/Todolist.git

## Step 2: install composer
https://getcomposer.org/download/

## Step 3: download back dependencies
        composer install

## Step 4: config your database in file .env
Exemple: DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7

## Step 5: create DB

        php bin/console d:d:c

## Step 6: update schema (create tables)

        php bin/console d:s:u -f
        OR
        php bin/console doctrine:migrations:migrate

## Step 7: load fixtures

        php bin/console do:fi:lo  

## Step 8: start server

        symfony serve

## Step 9: defaults users
<table>
    <thead>
        <tr>
            <th>pseudo</th>
            <th align="center">password</th>
            <th align="right">role</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>user0</td>
            <td align="center">user0</td>
            <td align="right">ROLE_USER</td>
        </tr>
        <tr>
            <td>admin1</td>
            <td align="center">admin1</td>
            <td align="right">ROLE_ADMIN</td>
        </tr>
        <tr>
            <td>user2</td>
            <td align="center">user2</td>
            <td align="right">ROLE_USER</td>
        </tr>
        <tr>
            <td>admin3</td>
            <td align="center">admin3</td>
            <td align="right">ROLE_ADMIN</td>
        </tr>
    </tbody>
</table>

## Unit and fonctionnal Tests
Unit tests require :

- PHP Unit
- LiipTestFixturesBundle
- XDebug php extension
        
To run test 

        php bin/phpunit 

## Run test coverage
        
        php bin/phpunit --coverage-html web/test-coverage

Access result on: todolist/web/test-coverage/index.html

## How to contribute
Read contributing.md 

## Documentations:
- Diagrammes : Todolist/documentation/UML/
- audit qualité et performance : Todolist/documentation/

# CONTEXTE DU PROJET
Projet 8 de mon parcours Développeur d'application PHP/Symfony chez OpenClassrooms. 

## Project summary
Vous venez d’intégrer une startup dont le cœur de métier est une application permettant de gérer ses tâches quotidiennes. L’entreprise vient tout juste d’être montée, et l’application a dû être développée à toute vitesse pour permettre de montrer à de potentiels investisseurs que le concept est viable (on parle de Minimum Viable Product ou MVP).

Le choix du développeur précédent a été d’utiliser le framework PHP Symfony, un framework que vous commencez à bien connaître ! 

Bonne nouvelle ! ToDo & Co a enfin réussi à lever des fonds pour permettre le développement de l’entreprise et surtout de l’application.

Votre rôle ici est donc d’améliorer la qualité de l’application. La qualité est un concept qui englobe bon nombre de sujets : on parle souvent de qualité de code, mais il y a également la qualité perçue par l’utilisateur de l’application ou encore la qualité perçue par les collaborateurs de l’entreprise, et enfin la qualité que vous percevez lorsqu’il vous faut travailler sur le projet.

Ainsi, pour ce dernier projet de spécialisation, vous êtes dans la peau d’un développeur expérimenté en charge des tâches suivantes :

l’implémentation de nouvelles fonctionnalités ;
la correction de quelques anomalies ;
et l’implémentation de tests automatisés.
Il vous est également demandé d’analyser le projet grâce à des outils vous permettant d’avoir une vision d’ensemble de la qualité du code et des différents axes de performance de l’application.

Il ne vous est pas demandé de corriger les points remontés par l’audit de qualité de code et de performance. Cela dit, si le temps vous le permet, ToDo & Co sera ravi que vous réduisiez la dette technique de cette application.

## Project needs
Corrections d'anomalies
Une tâche doit être attachée à un utilisateur
Actuellement, lorsqu’une tâche est créée, elle n’est pas rattachée à un utilisateur. Il vous est demandé d’apporter les corrections nécessaires afin qu’automatiquement, à la sauvegarde de la tâche, l’utilisateur authentifié soit rattaché à la tâche nouvellement créée.

Lors de la modification de la tâche, l’auteur ne peut pas être modifié.

Pour les tâches déjà créées, il faut qu’elles soient rattachées à un utilisateur “anonyme”.

Choisir un rôle pour un utilisateur
Lors de la création d’un utilisateur, il doit être possible de choisir un rôle pour celui-ci. Les rôles listés sont les suivants :

rôle utilisateur (ROLE_USER) ;
rôle administrateur (ROLE_ADMIN).
Lors de la modification d’un utilisateur, il est également possible de changer le rôle d’un utilisateur.

Implémentation de nouvelles fonctionnalités
Autorisation
Seuls les utilisateurs ayant le rôle administrateur (ROLE_ADMIN) doivent pouvoir accéder aux pages de gestion des utilisateurs.

Les tâches ne peuvent être supprimées que par les utilisateurs ayant créé les tâches en question.

Les tâches rattachées à l’utilisateur “anonyme” peuvent être supprimées uniquement par les utilisateurs ayant le rôle administrateur (ROLE_ADMIN).

Implémentation de tests automatisés
Il vous est demandé d’implémenter les tests automatisés (tests unitaires et fonctionnels) nécessaires pour assurer que le fonctionnement de l’application est bien en adéquation avec les demandes.

Ces tests doivent être implémentés avec PHPUnit ; vous pouvez aussi utiliser Behat pour la partie fonctionnelle.

Vous prévoirez des données de tests afin de pouvoir prouver le fonctionnement dans les cas explicités dans ce document.

Il vous est demandé de fournir un rapport de couverture de code au terme du projet. Il faut que le taux de couverture soit supérieur à 70 %.

Documentation technique
Il vous est demandé de produire une documentation expliquant comment l’implémentation de l'authentification a été faite. Cette documentation se destine aux prochains développeurs juniors qui rejoindront l’équipe dans quelques semaines. Dans cette documentation, il doit être possible pour un débutant avec le framework Symfony de :

comprendre quel(s) fichier(s) il faut modifier et pourquoi ;
comment s’opère l’authentification ;
et où sont stockés les utilisateurs.
S’il vous semble important de mentionner d’autres informations , n’hésitez pas à le faire.

Par ailleurs, vous ouvrez la marche en matière de collaboration à plusieurs sur ce projet. Il vous est également demandé de produire un document expliquant comment devront procéder tous les développeurs souhaitant apporter des modifications au projet.

Ce document devra aussi détailler le processus de qualité à utiliser ainsi que les règles à respecter.

Audit de qualité du code & performance de l'application
Les fondateurs souhaitent pérenniser le développement de l’application. Cela dit, ils souhaitent dans un premier temps faire un état des lieux de la dette technique de l’application.

Au terme de votre travail effectué sur l’application, il vous est demandé de produire un audit de code sur les deux axes suivants : la qualité de code et la performance.

Bien évidemment, il vous est fortement conseillé d’utiliser des outils vous permettant d’avoir des métriques pour appuyer vos propos.

Concernant l’audit de performance, l’usage de Blackfire est obligatoire. Ce dernier vous permettra de produire des analyses précises et adaptées aux évolutions futures du projet.

## Deliverables
- Un fichier contenant un lien vers l’ensemble du projet sur un repository GitHub (fichiers PHP/HTML/JS/CSS…)
- Les instructions pour installer le projet (dans un fichier README à la racine du projet)
- Les issues sur le repository GitHub
Documentation technique concernant l’implémentation de l’authentification (fichier au format PDF)
- L’ensemble des fichiers HTML générés par PHPUnit indiquant le niveau de code coverage de l’application (un minimum de 70 %)
- Document expliquant comment contribuer au projet (fichier markdown “.md”)
- Le rapport d’audit de qualité de code et de performance (fichier au format PDF)