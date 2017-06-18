<?php 
namespace schilter\gw2challenges\Controller;

/*
 * This file is part of the schilter.gw2challenges package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;

class ChallengeController_Original extends ActionController
{
	/**
	 * @Flow\Inject
	 * @var \Neos\Flow\Security\Context
	 */
	protected $securityContext;
	
	/**
	 * @Flow\Inject
	 * @var \schilter\gw2challenges\Domain\Repository\MiniRepository
	 */
	protected $miniRepository;
	
	/**
	 * @Flow\Inject
	 * @var \schilter\gw2challenges\Domain\Repository\UserRepository
	 */
	protected $userRepository;
	
	/**
	 * @Flow\Inject
	 * @var \schilter\gw2challenges\Domain\Repository\ChallengeRepository
	 */
	protected $challengeRepository;

	
	public function listAction(){
		if($this->securityContext->getAccount()){			
			$user = $this->userRepository->findByAccount($this->securityContext->getAccount());
			$ids = explode(',', $user->getChallenges());	
			array_shift($ids);
			if(count($ids) > 0){		
				$challenges = array();			
				foreach($ids as $id){
					$challenge = $this->challengeRepository->getById($id);
					$challenges[] = array(
							'id' => $challenge->getId(),
							'name' => $challenge->getName(),
							'minis' => $this->getMinis($challenge->getMinis())
					);
				}				
				$this->view->assign('challenges', $challenges);
			}
			else{
				$this->addFlashMessage('No Challenges found', 'Error', \Neos\Error\Messages\Message::SEVERITY_ERROR);
				$this->redirect('index', 'Mini');
			}
		}
		else{
			$this->addFlashMessage('Please Log in first', 'Error', \Neos\Error\Messages\Message::SEVERITY_ERROR);
			$this->redirect('index', 'Mini');
		}
	}
	
	public function newAction(){
		$this->view->assign('minis', json_encode($this->miniRepository->findAll()));
	}
	
	/**
	 * 
	 * @param string $name
	 * @param string $ids
	 */
	public function createAction($name, $ids){
		if($this->securityContext->getAccount()){
			$user = $this->userRepository->findByAccount($this->securityContext->getAccount());
			$identifier = $this->challengeRepository->newChallenge($name, rtrim($ids, ','));	
			$id = $this->challengeRepository->getIdByIdentifier($identifier);		
			$this->userRepository->updateChallenges($id);
			$this->addFlashMessage('Challenge created');
		}
		else{
			$this->addFlashMessage('Please Log in first', 'Error', \Neos\Error\Messages\Message::SEVERITY_ERROR);			
		}
		$this->redirect('index', 'Mini');
		
	}
	
	protected function getMinis($ids){
		$user = $this->userRepository->findByAccount($this->securityContext->getAccount());
		$userIds = explode(',', $user->getMinis());
		
		$minis = array();
		foreach(explode(',',$ids) as $id){
			$mini = $this->miniRepository->getById($id);
			$minis[] = array(
					'id' => $mini->getId(),
					'name' => $mini->getName(),
					'icon' => $mini->getIcon(),
					'reached' => in_array($mini->getId(), $userIds) ? 'Reached' : 'Not yet'
			);
		}
		return $minis;
	}
}



#
# Start of Flow generated Proxy code
#
namespace schilter\gw2challenges\Controller;

use Doctrine\ORM\Mapping as ORM;
use Neos\Flow\Annotations as Flow;

/**
 * 
 */
class ChallengeController extends ChallengeController_Original implements \Neos\Flow\ObjectManagement\Proxy\ProxyInterface {

    use \Neos\Flow\ObjectManagement\Proxy\ObjectSerializationTrait, \Neos\Flow\ObjectManagement\DependencyInjection\PropertyInjectionTrait;


    /**
     * Autogenerated Proxy Method
     */
    public function __construct()
    {
        if ('schilter\gw2challenges\Controller\ChallengeController' === get_class($this)) {
            $this->Flow_Proxy_injectProperties();
        }
    }

    /**
     * Autogenerated Proxy Method
     */
    public function __sleep()
    {
            $result = NULL;
        $this->Flow_Object_PropertiesToSerialize = array();

        $transientProperties = array (
);
        $propertyVarTags = array (
  'securityContext' => '\\Neos\\Flow\\Security\\Context',
  'miniRepository' => '\\schilter\\gw2challenges\\Domain\\Repository\\MiniRepository',
  'userRepository' => '\\schilter\\gw2challenges\\Domain\\Repository\\UserRepository',
  'challengeRepository' => '\\schilter\\gw2challenges\\Domain\\Repository\\ChallengeRepository',
  'objectManager' => 'Neos\\Flow\\ObjectManagement\\ObjectManagerInterface',
  'reflectionService' => 'Neos\\Flow\\Reflection\\ReflectionService',
  'mvcPropertyMappingConfigurationService' => 'Neos\\Flow\\Mvc\\Controller\\MvcPropertyMappingConfigurationService',
  'viewConfigurationManager' => 'Neos\\Flow\\Mvc\\ViewConfigurationManager',
  'view' => 'Neos\\Flow\\Mvc\\View\\ViewInterface',
  'viewObjectNamePattern' => 'string',
  'viewFormatToObjectNameMap' => 'array',
  'defaultViewObjectName' => 'string',
  'defaultViewImplementation' => 'string',
  'actionMethodName' => 'string',
  'errorMethodName' => 'string',
  'settings' => 'array',
  'systemLogger' => 'Neos\\Flow\\Log\\SystemLoggerInterface',
  'uriBuilder' => 'Neos\\Flow\\Mvc\\Routing\\UriBuilder',
  'validatorResolver' => 'Neos\\Flow\\Validation\\ValidatorResolver',
  'request' => 'Neos\\Flow\\Mvc\\ActionRequest',
  'response' => 'Neos\\Flow\\Http\\Response',
  'arguments' => 'Neos\\Flow\\Mvc\\Controller\\Arguments',
  'controllerContext' => 'Neos\\Flow\\Mvc\\Controller\\ControllerContext',
  'flashMessageContainer' => 'Neos\\Flow\\Mvc\\FlashMessageContainer',
  'persistenceManager' => 'Neos\\Flow\\Persistence\\PersistenceManagerInterface',
  'supportedMediaTypes' => 'array',
);
        $result = $this->Flow_serializeRelatedEntities($transientProperties, $propertyVarTags);
        return $result;
    }

    /**
     * Autogenerated Proxy Method
     */
    public function __wakeup()
    {

        $this->Flow_setRelatedEntities();
        $this->Flow_Proxy_injectProperties();
    }

    /**
     * Autogenerated Proxy Method
     */
    private function Flow_Proxy_injectProperties()
    {
        $this->injectSettings(\Neos\Flow\Core\Bootstrap::$staticObjectManager->get(\Neos\Flow\Configuration\ConfigurationManager::class)->getConfiguration('Settings', 'schilter.gw2challenges'));
        $this->Flow_Proxy_LazyPropertyInjection('Neos\Flow\Security\Context', 'Neos\Flow\Security\Context', 'securityContext', 'f7e2ddeaebd191e228b8c2e4dc7f1f83', function() { return \Neos\Flow\Core\Bootstrap::$staticObjectManager->get('Neos\Flow\Security\Context'); });
        $this->Flow_Proxy_LazyPropertyInjection('schilter\gw2challenges\Domain\Repository\MiniRepository', 'schilter\gw2challenges\Domain\Repository\MiniRepository', 'miniRepository', 'b3e18de92e5fae7ba6088f5d18991785', function() { return \Neos\Flow\Core\Bootstrap::$staticObjectManager->get('schilter\gw2challenges\Domain\Repository\MiniRepository'); });
        $this->Flow_Proxy_LazyPropertyInjection('schilter\gw2challenges\Domain\Repository\UserRepository', 'schilter\gw2challenges\Domain\Repository\UserRepository', 'userRepository', '48ddfecbb0948caa0c7b056b06d3b0c9', function() { return \Neos\Flow\Core\Bootstrap::$staticObjectManager->get('schilter\gw2challenges\Domain\Repository\UserRepository'); });
        $this->Flow_Proxy_LazyPropertyInjection('schilter\gw2challenges\Domain\Repository\ChallengeRepository', 'schilter\gw2challenges\Domain\Repository\ChallengeRepository', 'challengeRepository', '3a94189af35e2a39929cc86e4bf613c9', function() { return \Neos\Flow\Core\Bootstrap::$staticObjectManager->get('schilter\gw2challenges\Domain\Repository\ChallengeRepository'); });
        $this->Flow_Proxy_LazyPropertyInjection('Neos\Flow\ObjectManagement\ObjectManagerInterface', 'Neos\Flow\ObjectManagement\ObjectManager', 'objectManager', '9524ff5e5332c1890aa361e5d186b7b6', function() { return \Neos\Flow\Core\Bootstrap::$staticObjectManager->get('Neos\Flow\ObjectManagement\ObjectManagerInterface'); });
        $this->Flow_Proxy_LazyPropertyInjection('Neos\Flow\Reflection\ReflectionService', 'Neos\Flow\Reflection\ReflectionService', 'reflectionService', '464c26aa94c66579c050985566cbfc1f', function() { return \Neos\Flow\Core\Bootstrap::$staticObjectManager->get('Neos\Flow\Reflection\ReflectionService'); });
        $this->Flow_Proxy_LazyPropertyInjection('Neos\Flow\Mvc\Controller\MvcPropertyMappingConfigurationService', 'Neos\Flow\Mvc\Controller\MvcPropertyMappingConfigurationService', 'mvcPropertyMappingConfigurationService', '245f31ad31ca22b8c2b2255e0f65f847', function() { return \Neos\Flow\Core\Bootstrap::$staticObjectManager->get('Neos\Flow\Mvc\Controller\MvcPropertyMappingConfigurationService'); });
        $this->Flow_Proxy_LazyPropertyInjection('Neos\Flow\Mvc\ViewConfigurationManager', 'Neos\Flow\Mvc\ViewConfigurationManager', 'viewConfigurationManager', '40e27e95b530777b9b476762cf735a69', function() { return \Neos\Flow\Core\Bootstrap::$staticObjectManager->get('Neos\Flow\Mvc\ViewConfigurationManager'); });
        $this->Flow_Proxy_LazyPropertyInjection('Neos\Flow\Log\SystemLoggerInterface', 'Neos\Flow\Log\Logger', 'systemLogger', '717e9de4d0309f4f47c821b9257eb5c2', function() { return \Neos\Flow\Core\Bootstrap::$staticObjectManager->get('Neos\Flow\Log\SystemLoggerInterface'); });
        $this->Flow_Proxy_LazyPropertyInjection('Neos\Flow\Validation\ValidatorResolver', 'Neos\Flow\Validation\ValidatorResolver', 'validatorResolver', 'e992f50de62d81bfe770d5c5f1242621', function() { return \Neos\Flow\Core\Bootstrap::$staticObjectManager->get('Neos\Flow\Validation\ValidatorResolver'); });
        $this->Flow_Proxy_LazyPropertyInjection('Neos\Flow\Mvc\FlashMessageContainer', 'Neos\Flow\Mvc\FlashMessageContainer', 'flashMessageContainer', 'a5f5265657df54eb081324fb2ff5b8e1', function() { return \Neos\Flow\Core\Bootstrap::$staticObjectManager->get('Neos\Flow\Mvc\FlashMessageContainer'); });
        $this->Flow_Proxy_LazyPropertyInjection('Neos\Flow\Persistence\PersistenceManagerInterface', 'Neos\Flow\Persistence\Doctrine\PersistenceManager', 'persistenceManager', '8a72b773ea2cb98c2933df44c659da06', function() { return \Neos\Flow\Core\Bootstrap::$staticObjectManager->get('Neos\Flow\Persistence\PersistenceManagerInterface'); });
        $this->defaultViewImplementation = \Neos\Flow\Core\Bootstrap::$staticObjectManager->get(\Neos\Flow\Configuration\ConfigurationManager::class)->getConfiguration('Settings', 'Neos.Flow.mvc.view.defaultImplementation');
        $this->Flow_Injected_Properties = array (
  0 => 'settings',
  1 => 'securityContext',
  2 => 'miniRepository',
  3 => 'userRepository',
  4 => 'challengeRepository',
  5 => 'objectManager',
  6 => 'reflectionService',
  7 => 'mvcPropertyMappingConfigurationService',
  8 => 'viewConfigurationManager',
  9 => 'systemLogger',
  10 => 'validatorResolver',
  11 => 'flashMessageContainer',
  12 => 'persistenceManager',
  13 => 'defaultViewImplementation',
);
    }
}
# PathAndFilename: /var/www/php/Packages/Application/schilter.gw2challenges/Classes/Controller/ChallengeController.php
#