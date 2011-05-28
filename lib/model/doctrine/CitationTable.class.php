<?php


class CitationTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Citation');
    }
    
    public function findActive()
    {
        $q = $this->createQuery('a')
          ->where('a.is_active = ? ', 1);
 
        return $q->execute();
    }
  
  public function addCitation($text, $auteur, $source, $website) {
    
      if ($text != '')
      {
        $citation = Doctrine::getTable('Citation')->findByQuote($text);
        if (count($citation) == 0)
        {
          echo "***** New citation : $text ***** \n";
          $new_citation = new Citation;
          $new_citation->quote = $text;
          $new_citation->author = $auteur;
          $new_citation->source = $source;
          $new_citation->website = $website;
          $new_citation->last_published_at  = '0000-00-00 00:00:00';
          $new_citation->is_active = 0;
          $new_citation->save();
        }
      }
  }
}