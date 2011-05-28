<?php


class AuthorTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Author');
    }
  
  public function addAuthor($auteur) {
    
      if ($auteur != '')
      {
        $auteurs = Doctrine::getTable('Author')->findByAuthor($auteur);
        if (count($auteurs) == 0)
        {
          $new_auteur = new Author;
          $new_auteur->author = $auteur;
          $new_auteur->is_active = 1;
          $new_auteur->save();
        }
      }
  }
}