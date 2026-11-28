# Rapport de qualité MediaHub (semaine 11)

## Tests

- Tests écrits : 18 nouveaux tests, plus les 2 tests par défaut, soit 20 au total
- Résultat de `php artisan test` : 20 réussis, 0 échec (remplace par tes chiffres réels)
- Base de test : SQLite en mémoire, isolée de MySQL

| Fichier | Sujet | Tests |
|---|---|---|
| CategorieTest | CRUD des catégories, slug unique, invalidation du cache | 4 |
| AuthTest | inscription, connexion, déconnexion | 4 |
| PublicationPolicyTest | accès visiteur, auteur, intrus, admin | 4 |
| Api/PublicationApiTest | liste, jeton, création, 401, 403 | 6 |
| ContenuListTest | nombre de requêtes de la liste | 1 |

## Requête N+1

- Page concernée : liste des publications (`/contenus`)
- Problème : `$publication->commentaires->count()` dans la boucle Blade exécutait une requête par publication (9 requêtes sur les commentaires pour 9 cartes)
- Correction : `withCount('commentaires')` dans `ContenuController::index` et affichage de `commentaires_count`
- Résultat : 1 requête au lieu de 9 pour les commentaires, soit 4 requêtes au total sur la page
- Vérification automatique : `ContenuListTest`

## Cache

- Donnée : liste des catégories avec le nombre de publications (clé `categories.liste`)
- Durée de validité : 3600 secondes (1 heure)
- Invalidation : à la création, la modification et la suppression d'une catégorie, et à chaque création, modification, suppression ou restauration d'une publication