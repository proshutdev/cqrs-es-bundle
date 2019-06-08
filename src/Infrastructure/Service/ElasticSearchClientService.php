<?php
/*
* This file is part of the Proshut application project
* (c) Proshut Web Development Company <info@proshut.biz> | 6/3/19
* For the full copyright and license information, please view the LICENSE
*/

namespace Proshut\CQRSBundle\Infrastructure\Service;

use Elasticsearch\ClientBuilder;
use Proshut\CQRSBundle\Exception\ElasticSearchReadModelPersistenceException;

/**
 * Description of ElasticSearchClientService
 *
 * @author Proshut Web Development <info at proshut.biz>
 */
class ElasticSearchClientService {

    private $clientBuilder;
    public const INDEX = 'proshut';

    public function __construct( ClientBuilder $clientBuilder ) {
        $this->clientBuilder = $clientBuilder;
    }

    public function create() {
        return $this->clientBuilder::create()->setHosts([ [ 'host' => $_ENV[ 'ELASTICSEARCH_HOST' ],
                                                            'port' => $_ENV[ 'ELASTICSEARCH_PORT' ] ] ])->build();
    }

    public function index( array $params ) {
        $Client = $this->create();
        $Result = $Client->index($params);
        if ($Result[ '_shards' ][ 'successful' ] < 1) {
            throw new ElasticSearchReadModelPersistenceException('error.readmodel.global.persistence');
        }
    }

    public function search( array $params ) {
        $Response = [ 'hits'  => [],
                      'total' => 0 ];
        $Client   = $this->create();
        $Result   = $Client->search($params);
        if ($Result) {
            $Response[ 'hits' ]  = array_map(function ( $hit ) {
                return array_merge([ 'id' => $hit[ '_id' ] ], $hit[ '_source' ]);
            }, $Result[ 'hits' ][ 'hits' ]);
            $Response[ 'total' ] = $Result[ 'hits' ][ 'total' ][ 'value' ];
        }
        return $Response;
    }

    public function get( array $params ) {
        $Result = $this->create()->get($params);
        if (!$Result) {
            return [];
        }
        return array_merge([ 'id' => $Result[ '_id' ] ], $Result[ '_source' ]);
    }

    public function update( array $params ) {
        $this->create()->update($params);
    }
}