<?php
namespace TranslateBundle\Controller;

use Symfony\Component\Translation\MessageCatalogue;
use Symfony\Component\Translation\Loader\LoaderInterface;

class CustomLoader implements LoaderInterface
{
    public function load($resource, $locale, $domain = 'messages')
    {
        $messages = array();
        $lines = file($resource);

        foreach ($lines as $line) {
            if (preg_match('/\(([^\)]+)\)\(([^\)]+)\)/', $line, $matches)) {
                $messages[$matches[1]] = $matches[2];
            }
        }

        $catalogue = new MessageCatalogue($locale);
        $catalogue->add($messages, $domain);

        return $catalogue;
    }

}