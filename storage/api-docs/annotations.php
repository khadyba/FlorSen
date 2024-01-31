<?php

/**
 * @OA\Security(
 *     security={
 *         "BearerAuth": {}
 *     },
 */


/**
 * @OA\SecurityScheme(
 *     securityScheme="BearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 */


/**
 * @OA\Info(
 *     title="Your API Title",
 *     description="Your API Description",
 *     version="1.0.0"
 */


/**
 * @OA\Consumes({
 *     "application/json"
 * })
 */


/**
 * @OA\PUT(
 *     path="/api/ModifierCategorie/",
 *     summary="ModifierCategorie",
 *     description="",
 * @OA\Response(response="200", description="OK")
 *     @OA\Parameter(in="path", name="id", required=false, @OA\Schema(type="string")
 * )
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             example=
  * {
 *     "nom": "les  herbacées"
 * }
 *         )
 *     ),
 *     tags={"Categories"},
 * )
 */


/**
 * @OA\POST(
 *     path="/api/AjouterCategorie",
 *     summary="AjouterCategorie",
 *     description="",
 * @OA\Response(response="201", description="Created successfully")
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             example=
  * {
 *     "nom": "les Arbres "
 * }
 *         )
 *     ),
 *     tags={"Categories"},
 * )
 */


/**
 * @OA\GET(
 *     path="/api/rechercheParCategorie/",
 *     summary="filterParCategorieProduits",
 *     description="",
 * @OA\Response(response="200", description="OK")
 *     @OA\Parameter(in="path", name="id", required=false, @OA\Schema(type="string")
 * )
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     tags={"clients"},
 * )
 */


/**
 * @OA\GET(
 *     path="/api/ListerProduit",
 *     summary="ListeProduits",
 *     description="",
 * @OA\Response(response="200", description="OK")
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     tags={"clients"},
 * )
 */


/**
 * @OA\GET(
 *     path="/api/VoirDetailProduits/",
 *     summary="VoirDetailProduits",
 *     description="",
 * @OA\Response(response="200", description="OK")
 *     @OA\Parameter(in="path", name="produits", required=false, @OA\Schema(type="string")
 * )
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     tags={"Produits"},
 * )
 */


/**
 * @OA\POST(
 *     path="/api/ContacterJardinier/",
 *     summary="ContacterJardinier",
 *     description="",
 * @OA\Response(response="201", description="Created successfully")
 *     @OA\Parameter(in="path", name="id", required=false, @OA\Schema(type="string")
 * )
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     tags={"clients"},
 * )
 */


/**
 * @OA\GET(
 *     path="/api/ConsulterProfile/",
 *     summary="ConsulterProfilJardinier",
 *     description="",
 * @OA\Response(response="200", description="OK")
 *     @OA\Parameter(in="path", name="jardinier", required=false, @OA\Schema(type="string")
 * )
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     tags={"clients"},
 * )
 */


/**
 * @OA\DELETE(
 *     path="/api/RetirerProduits/",
 *     summary="RetirerProduitDeLaListe",
 *     description="",
 * @OA\Response(response="204", description="Deleted successfully")
 *     @OA\Parameter(in="path", name="produits", required=false, @OA\Schema(type="string")
 * )
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     tags={"Produits"},
 * )
 */


/**
 * @OA\GET(
 *     path="/api/ListerProduits",
 *     summary="ListerProduits",
 *     description="",
 * @OA\Response(response="200", description="OK")
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     tags={"Produits"},
 * )
 */


/**
 * @OA\DELETE(
 *     path="/api/SupprimerProduits/",
 *     summary="SupprimerProduits",
 *     description="",
 * @OA\Response(response="204", description="Deleted successfully")
 *     @OA\Parameter(in="path", name="produits", required=false, @OA\Schema(type="string")
 * )
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     tags={"Produits"},
 * )
 */


/**
 * @OA\POST(
 *     path="/api/ModifierProduits/",
 *     summary="ModifierProduits",
 *     description="",
 * @OA\Response(response="201", description="Created successfully")
 *     @OA\Parameter(in="path", name="produits", required=false, @OA\Schema(type="string")
 * )
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             example=
  * {
 *     "nom": "l'aloevéra.",
 *     "description": "L’aloe véritable (Aloe vera) peut être cultivée dans le jardin pendant les mois d’été comme plante en bac. Toutefois, son quartier d’hiver nécessite une température d’au moins 10 °C. Elle n’a pas besoin de beaucoup d’eau..",
 *     "image": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzJFBI5yUXDvpLkWClJ_3EZi-ontS_IYpvZg&usqp=CAU",
 *     "categories_id": "4"
 * }
 *         )
 *     ),
 *     tags={"Produits"},
 * )
 */


/**
 * @OA\POST(
 *     path="/api/PublierProduits",
 *     summary="PublierProduits",
 *     description="",
 * @OA\Response(response="201", description="Created successfully")
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             example=
  * {
 *     "nom": "l'aloevéra.",
 *     "description": "L’aloe véritable (Aloe vera) peut être cultivée dans le jardin pendant les mois d’été comme plante en bac. Toutefois, son quartier d’hiver nécessite une température d’au moins 10 °C. Elle n’a pas besoin de beaucoup d’eau..",
 *     "image": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzJFBI5yUXDvpLkWClJ_3EZi-ontS_IYpvZg&usqp=CAU",
 *     "categories_id": "4"
 * }
 *         )
 *     ),
 *     tags={"Produits"},
 * )
 */


/**
 * @OA\GET(
 *     path="/api/listerCommentaire",
 *     summary="listerCommentaire",
 *     description="",
 * @OA\Response(response="200", description="OK")
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     tags={"Commentaires"},
 * )
 */


/**
 * @OA\DELETE(
 *     path="/api/SupprimerCommentaire/",
 *     summary="SupprimerCommentaire",
 *     description="",
 * @OA\Response(response="204", description="Deleted successfully")
 *     @OA\Parameter(in="path", name="commentaire", required=false, @OA\Schema(type="string")
 * )
 *     @OA\Parameter(in="path", name="", required=false, @OA\Schema(type="string")
 * )
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     tags={"Commentaires"},
 * )
 */


/**
 * @OA\POST(
 *     path="/api/ModifierCommentaire/",
 *     summary="ModifierCommentaire",
 *     description="",
 * @OA\Response(response="201", description="Created successfully")
 *     @OA\Parameter(in="path", name="article", required=false, @OA\Schema(type="string")
 * )
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             example=
  * {
 *     "contenue": "les article sont intéresant!"
 * }
 *         )
 *     ),
 *     tags={"Commentaires"},
 * )
 */


/**
 * @OA\POST(
 *     path="/api/AjouterCommentaire/",
 *     summary="AjouterCommentaire",
 *     description="",
 * @OA\Response(response="201", description="Created successfully")
 *     @OA\Parameter(in="path", name="article", required=false, @OA\Schema(type="string")
 * )
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             example=
  * {
 *     "contenue": "j'adore vos article!"
 * }
 *         )
 *     ),
 *     tags={"Commentaires"},
 * )
 */


/**
 * @OA\POST(
 *     path="/api/SupprimerNewlettes/",
 *     summary="SeDésabonner",
 *     description="",
 * @OA\Response(response="201", description="Created successfully")
 *     @OA\Parameter(in="path", name="id", required=false, @OA\Schema(type="string")
 * )
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     tags={"Newletters"},
 * )
 */


/**
 * @OA\POST(
 *     path="/api/AjouterNewletters",
 *     summary="AjouterNewletters",
 *     description="",
 * @OA\Response(response="201", description="Created successfully")
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             example=
  * {
 *     "email": "mountaga889@gmail.com"
 * }
 *         )
 *     ),
 *     tags={"Newletters"},
 * )
 */


/**
 * @OA\GET(
 *     path="/api/VoirDetailArticle/",
 *     summary="VoirDetailArticle",
 *     description="",
 * @OA\Response(response="200", description="OK")
 *     @OA\Parameter(in="path", name="id", required=false, @OA\Schema(type="string")
 * )
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     tags={"Article"},
 * )
 */


/**
 * @OA\GET(
 *     path="/api/ListeArticle",
 *     summary="ListeArticle",
 *     description="",
 * @OA\Response(response="200", description="OK")
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     tags={"Article"},
 * )
 */


/**
 * @OA\DELETE(
 *     path="/api/destroyArticle/",
 *     summary="SupprimerArticle",
 *     description="",
 * @OA\Response(response="204", description="Deleted successfully")
 *     @OA\Parameter(in="path", name="id", required=false, @OA\Schema(type="string")
 * )
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     tags={"Article"},
 * )
 */


/**
 * @OA\POST(
 *     path="/api/updateArticle/",
 *     summary="ModifierArticle",
 *     description="",
 * @OA\Response(response="201", description="Created successfully")
 *     @OA\Parameter(in="path", name="id", required=false, @OA\Schema(type="string")
 * )
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             example=
  * {
 *     "titre": "Arrosage du mimosa",
 *     "image": "https://www.jardiner-malin.fr/wp-content/uploads/2019/11/mimosa-en-fleur.jpg",
 *     "contenue": "Le mimosa n’est pas un arbre qui demande beaucoup d’arrosage, sauf s’il est en pot évidemment. Il redoute en revanche les excès d’humidité qui ont tendance à faire pourrir les racines et donc votre arbre."
 * }
 *         )
 *     ),
 *     tags={"Article"},
 * )
 */


/**
 * @OA\POST(
 *     path="/api/createArticle",
 *     summary="AjouterArticle",
 *     description="",
 * @OA\Response(response="201", description="Created successfully")
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             example=
  * {
 *     "titre": " Quatriéme  Article",
 *     "image": "https://monjardinmamaison.maison-travaux.fr/wp-content/uploads/sites/8/2012/07/Toona-sinensis-Flamingo.jpg",
 *     "contenue": "Contenu du Quatriéme  article."
 * }
 *         )
 *     ),
 *     tags={"Article"},
 * )
 */


/**
 * @OA\POST(
 *     path="/api/modifierProfil/",
 *     summary="ModifierProfile",
 *     description="",
 * @OA\Response(response="201", description="Created successfully")
 *     @OA\Parameter(in="path", name="id", required=false, @OA\Schema(type="string")
 * )
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             example=
  * {
 *     "prenom": "Sarah",
 *     "nom": "Ba",
 *     "adresse": "ben tally",
 *     "telephone": "77-145-78-26"
 * }
 *         )
 *     ),
 *     tags={"User"},
 * )
 */


/**
 * @OA\POST(
 *     path="/api/debloquerUser/",
 *     summary="DebloquerUser",
 *     description="",
 * @OA\Response(response="201", description="Created successfully")
 *     @OA\Parameter(in="path", name="id", required=false, @OA\Schema(type="string")
 * )
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     tags={"User"},
 * )
 */


/**
 * @OA\POST(
 *     path="/api/blockUser/",
 *     summary="BloquerUser",
 *     description="",
 * @OA\Response(response="201", description="Created successfully")
 *     @OA\Parameter(in="path", name="id", required=false, @OA\Schema(type="string")
 * )
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     tags={"User"},
 * )
 */


/**
 * @OA\GET(
 *     path="/api/listClients",
 *     summary="lister les clients",
 *     description="",
 * @OA\Response(response="200", description="OK")
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     tags={"User"},
 * )
 */


/**
 * @OA\GET(
 *     path="/api/listJardinier",
 *     summary="lister les jardinier",
 *     description="",
 * @OA\Response(response="200", description="OK")
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     tags={"User"},
 * )
 */


/**
 * @OA\POST(
 *     path="/api/refresh",
 *     summary="Refresh",
 *     description="",
 * @OA\Response(response="201", description="Created successfully")
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     tags={"User"},
 * )
 */


/**
 * @OA\POST(
 *     path="/api/logout",
 *     summary="Logout",
 *     description="",
 * @OA\Response(response="201", description="Created successfully")
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     tags={"User"},
 * )
 */


/**
 * @OA\POST(
 *     path="/api/register",
 *     summary="Register",
 *     description="",
 * @OA\Response(response="201", description="Created successfully")
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             example=
  * {
 *     "prenom": "Abdou",
 *     "nom": "gaye",
 *     "adresse": "grand-dakar",
 *     "telephone": "771457826",
 *     "email": "email@gmail.com",
 *     "password": "12345678"
 * }
 *         )
 *     ),
 *     tags={"User"},
 * )
 */


/**
 * @OA\POST(
 *     path="/api/login",
 *     summary="Login",
 *     description="",
 * @OA\Response(response="201", description="Created successfully")
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             example=
  * {
 *     "email": "bak92147@gmail.com",
 *     "password": "12345678"
 * }
 *         )
 *     ),
 *     tags={"User"},
 * )
 */


