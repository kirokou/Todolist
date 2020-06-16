# Contributing

L'application TodoList est un projet collaboratif.
Veuillez d'abord lire le fichier readme.md à la racine du projet.
Suivez ensuite les étapes de contribution de ce projet.

## Signaler des bugs ou proposer une nouvelle fonctionnalité.
Vous pouvez signaler un bug ou demander l'ajout d'une fonctionnalité sur l'application en créant un pull request. 

Pour ce veuillez respecter ces quelques règles:
* Donnez un titre aussi clair et court que possible
* Décrivez clairement le problème. Dans le cas d'un bug, donnez le plus de détails possible sur votre environnement (OS, version PHP, extensions ...) et décrivez les étapes pour reproduire le bug
* Utilisez le bug ou l'étiquette de fonctionnalité pour votre problème

## Les instructions

### Step 1: Fork le repository

### Step 2: Cloner votre fork

### Step 3: Installer le projet
Intaller le projet en suivant les instructions du fichier readme.md à la racine du projet.

### Step 4: Comment travailler sur le projet

1. Créer un nouvelle branche en respectant les conventions.

    git checkout -b [prefix]/[name]

Pour votre contribution, veuillez respecter les conventions suivantes:

- `hotfix/` : pour les modifications/bugs
- `feature/` : pour l'ajout de nouvelles fonctionnalités. 

2. Travailler sur votre branche.
  
3. Tests et couvertures de test.
L'application est couvers par les tests unitaires et fonctionnels. Vous trouvez le rapport de couverture dans le dossier web/test-coverage/index à la racine.

Implémentez vos propres tests et testez votre code

4. Verifier la qualité de votre code
Avant de commiter votre code, vérifier la qualité de votre code.

5. Commiter votre code
`git commit -am 'add some feature'`

5. Push votre branch
`git push origin my-new-feature`

### E. Créer un merge request.

Accédez à votre fork sur votre compte Github pour ouvrir une demande de fusion. Fournissez un titre clair et des explications concises sur votre travail dans la description de votre demande de fusion. Ajoutez une référence de problème.

Maintenant que vous êtes sûr de votre travail, vous pouvez cliquer sur «Créer une demande de fusion» et cibler le projet «branchez».

Github exécutera automatiquement des tests et le code sera vérifié avec codacy et travis. Votre code doit réussir sur la syntaxe et l'étape de test pour avoir une chance d'être fusionné.

Si votre pull request est conforme aux recommandations de contribution du projet, votre fonctionnalité ou correction sera intégrée dans l'application.

## Standards à respecter
  - [PHP Standards Recommendations (PSR)][7]
  - [PSR-1][8]
  - [PSR-12][9]
  - [PSR-4][10]
  - [Symfony Coding Standards][11]

## Les Best Practices
- [Symfony Best Practices][12]
- [Doctrine Best Practices][21]
 
## Install PHPStan :

    vendor\bin\phpstan

## Install PHP_codesniffer :

    vendor\bin\phpcs (analyse le code du projet)
    vendor\bin\phpcbf (corrige  automatiquement les erreurs)


## Les conventions de noms
* Utilisez des espaces de noms pour toutes vos classes et nommez-les dans UpperCamelCase
* Les variables, fonctions et arguments doivent être nommés dans camelCase

