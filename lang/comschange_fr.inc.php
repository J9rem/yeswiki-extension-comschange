<?php

/*
 * This file is part of the YesWiki Extension comschange.
 *
 * Authors : see README.md file that was distributed with this source code.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

  // actions/MyCommentsAction.php
  'COMMENT_RESERVED_TO_CONNECTED' => 'Veuillez vous connecter pour pouvoir utiliser l\'action "{{mycomments}}" !',

   // templates/aceditor/actions-builder.tpl.html
   "AB_management_commentstable_label" => "Table des commentaires",


   'COMMENT_DELETE' => 'Supprimer un commentaire',
   'COMMENT_TAG' => 'Page',
   'COMMENT_DATE' => 'Date',
   'COMMENT_USER' => 'Auteur·ice',
   'COMMENT_CONTENT' => 'Commentaire',
   'COMMENT_ON_PAGE' => 'Page parente',
   'COMMENT_CONFIRM_DELETE' => 'Voulez-vous supprimer le commentaire ? (action définitive)',
   'COMMENT_MODIFIED_BY' => 'Modifié par %{user}',

   // templates/comments/notify-email-*.twig
   'COMMENT_NEW_COMMENT' => 'Nouveau commentaire sur la page %{tag}',
   'COMMENT_NEW_COMMENT_ANSWER' => 'Nouvelle réponse à votre commentaire sur la page %{tag}',
   'COMMENT_NEW_COMMENT_MESSAGE' => 'Un nouveau commentaire a été écrit par %{user} sur la page %{tag} sur le site [%{site}].',
   'COMMENT_NEW_COMMENT_ANSWER_MESSAGE' => 'Une nouvelle réponse a été écrite par %{user} à votre commentaire sur la page %{tag} sur le site [%{site}].',

];
