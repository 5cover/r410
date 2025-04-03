# Schéma BDD

## 1. Table : `authors` (Auteurs)

Contient les informations sur les auteurs des publications.

| Champ          | Type         | Description |
|---------------|-------------|-------------|
| `id`          | SERIAL (PK) | Identifiant unique de l'auteur |
| `dblp_key`    | VARCHAR     | Clé unique utilisée par DBLP |
| `name`        | TEXT        | Nom complet |
| `affiliation` | TEXT        | Affiliation principale (nom du laboratoire/université) |
| `country`     | TEXT        | Pays d'affiliation |
| `orcid`       | VARCHAR     | Identifiant ORCID (si disponible) |

## 2. Table : `institutions` (Laboratoires & Universités)

Liste des institutions académiques et laboratoires impliqués dans les collaborations.

| Champ         | Type         | Description |
|--------------|-------------|-------------|
| `id`         | SERIAL (PK) | Identifiant unique |
| `name`       | TEXT        | Nom de l'institution |
| `acronym`    | TEXT        | Acronyme (ex. IRISA, CNRS, INRIA) |
| `country`    | TEXT        | Pays |
| `city`       | TEXT        | Ville |
| `latitude`   | FLOAT       | Latitude pour affichage sur la carte |
| `longitude`  | FLOAT       | Longitude pour affichage sur la carte |

## 3. Table : `publications` (Publications)

Répertorie les publications indexées par DBLP.

| Champ         | Type         | Description |
|--------------|-------------|-------------|
| `id`         | SERIAL (PK) | Identifiant unique |
| `dblp_key`   | VARCHAR     | Identifiant DBLP unique de la publication |
| `title`      | TEXT        | Titre de la publication |
| `year`       | INTEGER     | Année de publication |
| `venue`      | TEXT        | Conférence ou journal où la publication est parue |
| `doi`        | VARCHAR     | Identifiant DOI (si disponible) |
| `url`        | TEXT        | Lien vers la publication DBLP ou autre source |

---

### 4. Table : `authorships` (Relations auteurs-publications)

Assure la relation "plusieurs à plusieurs" entre `authors` et `publications`.

| Champ         | Type         | Description |
|--------------|-------------|-------------|
| `author_id`  | INTEGER (FK) | Référence vers `authors.id` |
| `publication_id` | INTEGER (FK) | Référence vers `publications.id` |

### 5. Table : `affiliations` (Relations auteurs-institutions)

Permet de suivre les affiliations multiples d'un auteur au fil du temps.

| Champ        | Type         | Description |
|-------------|-------------|-------------|
| `author_id` | INTEGER (FK) | Référence vers `authors.id` |
| `institution_id` | INTEGER (FK) | Référence vers `institutions.id` |
| `start_year` | INTEGER     | Année de début de l'affiliation |
| `end_year`   | INTEGER     | Année de fin de l'affiliation (NULL si toujours actif) |

## 6. Table : `collaborations` (Relations entre laboratoires via publications)

Permet d'identifier les collaborations entre laboratoires via des publications en commun.

| Champ             | Type         | Description |
|------------------|-------------|-------------|
| `institution1_id` | INTEGER (FK) | Référence vers `institutions.id` |
| `institution2_id` | INTEGER (FK) | Référence vers `institutions.id` |
| `publication_id`  | INTEGER (FK) | Référence vers `publications.id` |

## Données exploitables sur la carte

- **Institutions & Localisation** : Chaque institution peut être affichée sur la carte avec des marqueurs.
- **Relations entre institutions** : Des lignes peuvent relier deux institutions lorsqu'elles ont une publication commune.
- **Relations entre auteurs** : En affichant des graphes, on peut voir quels auteurs collaborent le plus.
- **Changements d'affiliation** : Suivi historique des affiliations des chercheurs.
- **Publications liées à une institution** : Permet de voir la productivité scientifique d'une université/laboratoire.

### Technologies à utiliser

- **Base de données** : PostgreSQL avec extension PostGIS si besoin d’analyse géographique.
- **Backend** : CodeIgniter pour les API REST de récupération des données.
- **Frontend** : Leaflet.js pour afficher la carte et les relations.
