<?php
declare(strict_types=1);

namespace App\Application\Actions\Publication;

use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Actions\Action;

class ListPublicationsAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
      $serverName = "nitecrawler.database.windows.net";
      $connectionOptions = array(
          "Database" => "NitecrawlerDB",
          "Uid" => "davecroll",
          "PWD" => "neVada12"
      );
      
      $conn = sqlsrv_connect($serverName, $connectionOptions);
      $tsql = "SELECT *
               FROM dbo.publications";
      
      $getResults = sqlsrv_query($conn, $tsql);
      $results; 

      if ($getResults == FALSE)
          echo (sqlsrv_errors());
      while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
          $results[] = $row;
      }

      sqlsrv_free_stmt($getResults);

      return $this->respondWithData($results);
    }
}
