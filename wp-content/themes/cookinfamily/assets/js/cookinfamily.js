/**
 * Script principal pour la gestion des requêtes AJAX des recettes
 * Ce script s'exécute une fois que le DOM est complètement chargé
 */
document.addEventListener('DOMContentLoaded', function() {
    console.log("Script chargé");
    // Ajoute un écouteur d'événement sur le bouton avec l'ID 'ajax_call'
    document.querySelector('#ajax_call').addEventListener('click', function() {
      // Crée un objet FormData pour envoyer les données
      let formData = new FormData();
      // Ajoute l'action WordPress qui sera appelée côté serveur
      formData.append('action', 'request_recettes');
    
      // Effectue la requête AJAX vers l'URL WordPress (définie dans functions.php)
      fetch(cookinfamily_js.ajax_url, {
        method: 'POST',     // Méthode HTTP POST
        body: formData,     // Données à envoyer
      }).then(function(response) {
        // Vérifie si la réponse est valide
        if (!response.ok) {
          throw new Error('Network response error.');
        }
  
        // Convertit la réponse en JSON
        return response.json();
      }).then(function(data) {
        // Pour chaque recette reçue
        data.posts.forEach(function(post) {
          // Insère le titre de la recette dans une nouvelle div
          document.querySelector('#ajax_return').insertAdjacentHTML(
            'beforeend', 
            '<div class="col-12 mb-5">' + post.post_title + '</div>'
          );
        });
      }).catch(function(error) {
        // Gestion des erreurs dans la console
        console.error('There was a problem with the fetch operation: ', error);
      });
    });
});