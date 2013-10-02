<?php
namespace Cose\Crud\service\impl;

use Cose\service\impl\Service,
	Cose\utils\ReflectionUtils,
	Cose\exception\ServiceException,
	Cose\exception\ServiceNoResultException,
	Cose\exception\ServiceNonUniqueResultException,
	Cose\exception\DAOException,
	Cose\exception\DAONoResultException,
	Cose\exception\DAONonUniqueResultException;
	
use	Cose\Crud\service\ICrudService;

use Cose\Security\service\SecurityContext;
use Cose\Security\exception\AuthorizationException;

/**
 * Servicio genérico crud.
 * 
 * @author bernardo
 *
 */
abstract class CrudService extends Service implements ICrudService{

	protected function authorize($method){
		
		if( ! SecurityContext::getInstance()->authorize( $this, $method ) )
			throw new AuthorizationException($method);
		
	}
	
			
	abstract function validateOnAdd( $entity );
	
	abstract function validateOnUpdate( $entity );
	
	abstract function validateOnDelete( $oid );
	
	/**
	 * (non-PHPdoc)
	 * @see service/Cose\Crud\service.ICrudService::add()
	 */
	public function add($entity){

		try {
			
			$this->authorize( __FUNCTION__ );
			
			$this->validateOnAdd( $entity );
			
			$this->getDAO()->add( $entity );
			

		} catch (DAOException $e){
			
			throw new ServiceException( $e->getMessage() );
			
		} catch (Exception $e) {

			throw new ServiceException( $e->getMessage() );
		
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see service/Cose\Crud\service.ICrudService::update()
	 */
	public function update($entity){

		try {
			
			$this->authorize( __FUNCTION__ );
			
			$this->validateOnUpdate( $entity );
			
			//persistimos los cambios.
			$this->getDAO()->update( $entity );
			
		} catch (DAOException $e){
			
			throw new ServiceException( $e->getMessage() );
			
		} catch (Exception $e) {

			throw new ServiceException( $e->getMessage() );
					
		}
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see service/Cose\Crud\service.ICrudService::delete()
	 */
	public function delete($oid){
		
		try {
			
			$this->authorize( __FUNCTION__ );
			
			$this->validateOnDelete( $oid );
			
			//se elimina la entity.
			$this->getDAO()->delete( $oid );
			
		} catch (DAOException $e){
			
			throw new ServiceException( $e->getMessage() );
			
		} catch (Exception $e) {

			throw new ServiceException( $e->getMessage() );
		
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see service/Cose\Crud\service.ICrudService::get()
	 */
	public function get($oid) {

		try {

			$this->authorize( __FUNCTION__ );
			
			//obtenemos la entity.
			$entity = $this->getDAO()->get( $oid );
			
			return $entity;
			
		} catch (DAOException $e){
			
			throw new ServiceException( $e->getMessage() );
						
		} catch (Exception $e) {

			throw new ServiceException( $e->getMessage() );
		
		}
	}

	
	/**
	 * (non-PHPdoc)
	 * @see service/Cose\Crud\service.ICrudService::getList()
	 */	
	public function getList($criteria){

			try {
				
				$this->authorize( __FUNCTION__ );
								
				//obtenemos las entities.
				$entities = $this->getDAO()->getList( $criteria );
				
				return $entities;
				
			} catch (DAOException $e) {

				throw new ServiceException( $e->getMessage() );
				
			} catch (PDOException $e) {

				throw new ServiceException( $e->getMessage() );
				
			} catch (Exception $e) {
				
				throw new ServiceException( $e->getMessage() );
			}
			
	}
	
	/**
	 * (non-PHPdoc)
	 * @see service/Cose\Crud\service.ICrudService::getSingleResult()
	 */
	public function getSingleResult( $criteria ){

			try {
				
				$this->authorize( __FUNCTION__ );
				
				//obtenemos la entity.
				$entity = $this->getDAO()->getSingleResult( $criteria );
				
				return $entity;
				
			} catch (DAONoResultException $e) {

				throw new ServiceNoResultException( $e->getMessage() );
			
			} catch (DAONonUniqueResultException $e) {

				throw new ServiceNonUniqueResultException( $e->getMessage() );
			
			} catch (DAOException $e) {

				throw new ServiceException( $e->getMessage() );
				
			} catch (PDOException $e) {

				throw new ServiceException( $e->getMessage() );
				
			} catch (Exception $e) {
				
				throw new ServiceException( $e->getMessage() );
			}
		
	}
	

	/**
	 * (non-PHPdoc)
	 * @see service/Cose\Crud\service.ICrudService::getCount()
	 */	
	public function getCount($criteria){

			try {
				
				$this->authorize( __FUNCTION__ );
				
				//obtenemos las entities.
				$count = $this->getDAO()->getCount( $criteria );
				
				return $count;
				
			} catch (DAOException $e) {

				throw new ServiceException( $e->getMessage() );
				
			} catch (PDOException $e) {

				throw new ServiceException( $e->getMessage() );
				
			} catch (Exception $e) {
				
				throw new ServiceException( $e->getMessage() );
			}
			
	}
	
}