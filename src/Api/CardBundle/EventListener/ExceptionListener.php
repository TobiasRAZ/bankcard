<?php
namespace Api\CardBundle\EventListener;
 
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
 
/**
* 
*/
class ExceptionListener
{
	public function onKernelException(GetResponseForExceptionEvent $event)
	{
		$response = new Response();
		$exception = $event->getException();
        $response->headers->set('Content-Type', 'application/json');

	    if ($event->getException() instanceof NotFoundHttpException) {

	    	$error = array(
	    			'error' => $exception->getStatusCode(),
	    			'message' => 'The ressource you tried to load was not found on this server'
	    		);
        	$response->setStatusCode($exception->getStatusCode());
			$response->setContent( json_encode($error) );
		    $event->setResponse($response);

	    }

	    if ($event->getException() instanceof MethodNotAllowedHttpException) {

	    	$error = array(
	    			'error' => $exception->getStatusCode(),
	    			'message' => 'Method not allowed for this ressource'
	    		);
        	$response->setStatusCode($exception->getStatusCode());
			$response->setContent( json_encode($error) );
		    $event->setResponse($response);
	    }
	    	
	}
}
