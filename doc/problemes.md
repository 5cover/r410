# Problèmes

## Représentations des sous-divisions administratives

France : départements, régions...

US : état, province...

On a choisi un dénominateur commun : un attribut *region* dont la signification change selon le pays ou se trouve la ville.

pays|signifiation de *region*
-|-
France|nom du département
US|code en 2 lettres de l'état

Un meilleur nom (pour éviter la confusion avec les régions français) aurait pu être "division_2", tel que

\# division|pays|signification
-|-|-
1|France|région
1|US|code en 2 lettres de l'état
2|France|nom du département
2|US|nom du *county*

pour réduire la taille de la base, on pourrait stocker les counties, états, départements, régions dans des tables séparés et les référencer par des idées mais par souci de simplicité on ne fait pas ça pour le moment.

## Clé primaire de _city

Simple maps fournit une clé primaire mais quand j'ai voulu ajouter la france je n'avais pas cette clé

donc j'ai juste fait un serial incrémenté automatiquement
