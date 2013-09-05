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

/**
 * Servicio genérico crud.
 * 
 * @author bernardo
 *
 */
abstract class CrudService extends Service implements ICrudService{

	abstract function validateOnAdd( $entity );
	
	abstract function validateOnUpdate( $entity );
	
	abstract function validateOnDelete( $oid );
	
	/**
	 * (non-PHPdoc)
	 * @see service/Cose\Crud\service.ICrudService::add()
	 */
	public function add($entity){

		try {
			
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
				$service = get_class($this) . "::" . __FUNCTION__;
				$service = $this;
				
				//SecurityContext::getInstance()->authorize( $this, __FUNCTION__ );
								
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
				$service = get_class($this) . "::" . __FUNCTION__;
				$service = $this;
				//SecurityContext::getInstance()->authorize( $this, __FUNCTION__ );
								
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
				$service = get_class($this) . "::" . __FUNCTION__;
				$service = $this;
				//SecurityContext::getInstance()->authorize( $this, __FUNCTION__ );
								
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