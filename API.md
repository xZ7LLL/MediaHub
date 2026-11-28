# API MediaHub

URL de base : `http://127.0.0.1:8000/api`

Envoyer systématiquement `Accept: application/json`.
Les routes protégées demandent `Authorization: Bearer <jeton>`.

| Méthode | URL | Authentification | Description |
|---|---|---|---|
| POST | `/connexion` | non | Obtenir un jeton |
| GET | `/publications` | non | Liste paginée (10 par page) |
| GET | `/publications/{id}` | non | Détail d'une publication |
| POST | `/publications` | oui | Créer une publication |
| PUT/PATCH | `/publications/{id}` | oui (auteur ou admin) | Modifier une publication |
| DELETE | `/publications/{id}` | oui (auteur ou admin) | Supprimer une publication |

## POST /connexion

Requête :

```json
{ "email": "ada@exemple.com", "password": "motdepasse" }
```

Réponse 200 :

```json
{ "token": "1|abc123..." }
```

Réponse 401 : `{ "message": "Identifiants incorrects." }`

## GET /publications

Réponse 200 :

```json
{
  "data": [
    {
      "id": 1,
      "titre": "Titre",
      "contenu": "Texte...",
      "categorie": "Image",
      "auteur": "Ada",
      "image": null,
      "publie_le": "2026-11-28"
    }
  ],
  "links": {},
  "meta": {}
}
```

## GET /publications/{id}

Réponse 200 : `{ "data": { ...publication } }`
Réponse 404 si elle n'existe pas.

## POST /publications

Requête :

```json
{ "titre": "Titre", "contenu": "Au moins 20 caractères...", "categorie_id": 1 }
```

Réponse 201 : `{ "data": { ...publication } }`
Réponse 401 sans jeton, 422 si les données sont invalides.

## PUT /publications/{id}

Même corps que la création.
Réponse 200 : `{ "data": { ...publication } }`
Réponse 403 si la publication appartient à un autre utilisateur.

## DELETE /publications/{id}

Réponse 204 sans contenu.
Réponse 403 si la publication appartient à un autre utilisateur.