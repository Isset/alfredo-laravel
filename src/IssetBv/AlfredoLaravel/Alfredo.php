<?php

namespace IssetBv\AlfredoLaravel;

use Response;
use Alfredo\Server;
use Alfredo\Payload\Pdf\Convert;
use Alfredo\Payload\Pdf\QueueItem;
use Alfredo\Payload\PayloadAbstract;
use Alfredo\ConversionUnableException;

class Alfredo
{
    protected $server;

    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    public function makePayload()
    {
        return new Convert;
    }

    public function makePayloadWithConverter($converter)
    {
        $payload = $this->makePayload();
        $payload->setConverter($converter);

        return $payload;
    }

    public function makePayloadWithCallback($callback)
    {
        $payload = $this->makePayload();
        $payload->setCallback($callback);

        return $payload;
    }

    public function makePayloadWithSources(array $sources)
    {
        $payload = $this->makePayload();

        foreach ($sources as $source => $content) {
            $method = 'add'.ucfirst($source);

            if (method_exists($payload, $method)) {
                $payload->$method($content);
            }
        }

        return $payload;
    }

    public function convert(PayloadAbstract $payload)
    {
        return $this->server->stream($payload);
    }

    public function stream($content)
    {
        if ($content instanceof PayloadAbstract) {
            $content = $this->convert($content);
        }

        return Response::stream(function() use ($content)
        {
            echo $content;
        }, 200, array('Content-type' => 'application/pdf'));
    }

    public function queue(PayloadAbstract $payload)
    {
        return $this->server->queue($payload);
    }

    public function getQueuedPayload($identifier)
    {
        $payload = new QueueItem;
        $payload->setIdentifier($identifier);

        return $this->server->getQueueItem($payload);
    }

    public function checkQueuedPayload($identifier)
    {
        try {
            $this->getQueuedPayload($identifier);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}