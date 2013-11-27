<?php
namespace Cose\Crud\dao\impl;

use Cose\criteria\ICriteria;

use Cose\persistence\PersistenceContext;
use Cose\persistence\PersistenceConfig;

use Cose\exception\DAOException,
	Cose\exception\DAONonUniqueResultException,
	Cose\exception\DAONoResultException,
	Cose\dao\impl\DoctrineDAO;

use Cose\Crud\dao\ICrudDAO;

/**
 * Implementación del DAO crud con doctrine
 *  
 * @author bernardo
 *
 */
abstract class CrudDAO extends DoctrineDAO implements ICrudDAO{

	
	public function __construct( $unitName=""){
		
		if(empty($unitName))
			$unitName = PersistenceConfig::getDefaultUnit();
			
		parent::__construct( $unitName );
	}
	
	
	/**
	 * (non-PHPdoc)
	 * @see dao/Cose\Crud\dao.ICrudDAO::getList()
	 */
	public function getList($criteria){

		try{
			
			$q = $this->getQuery($criteria);
	
			$entities = $q->getResult();

			return $entities;
			
		} catch (\Doctrine\ORM\Query\QueryException $e) {
		
			throw new DAOException( $e->getMessage() );
		
		} catch (\Exception $e) {
			
			throw new DAOException( $e->getMessage() );
			
		}			
	}

	/**
	 * (non-PHPdoc)
	 * @see dao/Cose\Crud\dao.ICrudDAO::getCount()
	 */
	function getCount( $criteria ){
	
		try{
			
			$q = $this->getQueryCount($criteria);
	
			$count = $q->getSingleScalarResult();

			return $count;
			
		} catch (\Doctrine\ORM\Query\QueryException $e) {
		
			throw new DAOException( $e->getMessage() );
		
		} catch (\Exception $e) {
			
			throw new DAOException( $e->getMessage() );
			
		}			
	}
	
	/**
	 * (non-PHPdoc)
	 * @see dao/Cose\Crud\dao.ICrudDAO::add()
	 */
	public function add($entity){

		try{
		
			$this->entityManager->persist($entity);
		
			//TODO 
			$this->entityManager->flush();

		} catch (\Doctrine\ORM\Query\QueryException $e) {
		
			throw new DAOException( $e->getMessage() );
			
			
		} catch (\Exception $e) {
			
			throw new DAOException( $e->getMessage() );
			
		}			
	}

	/**
	 * (non-PHPdoc)
	 * @see dao/Cose\Crud\dao.ICrudDAO::update()
	 */
	public function update($entity){

		try{
			$this->entityManager->merge($entity);

			//TODO 
			$this->entityManager->flush();

		} catch (\Doctrine\ORM\Query\QueryException $e) {
		
			throw new DAOException( $e->getMessage() );
			
		} catch (\Exception $e) {
			
			throw new DAOException( $e->getMessage() );
			
		}			
	}

	/**
	 * (non-PHPdoc)
	 * @see dao/Cose\Crud\dao.ICrudDAO::delete()
	 */
	public function delete($oid){

		try{
			
			$this->entityManager->remove( $this->get($oid) );
	
			//TODO 
			$this->entityManager->flush();
			
		} catch (\Doctrine\ORM\Query\QueryException $e) {
		
			throw new DAOException( $e->getMessage() );
			
		} catch (\Exception $e) {
			
			throw new DAOException( $e->getMessage() );
			
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see dao/Cose\Crud\dao.ICrudDAO::get()
	 */
	public function get($oid){
		
		try {
			
			return $this->getEntityManager()->find( $this->getClazz(), $oid );
			
		} catch (\Doctrine\ORM\Query\QueryException $e) {
		
			throw new DAOException( $e->getMessage() );
			
		} catch (\Exception $e) {
			
			throw new DAOException( $e->getMessage() );
			
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see dao/Cose\Crud\dao.ICrudDAO::getSingleResult()
	 */
	function getSingleResult( $criteria ){
		
		try {

			$q = $this->getQuery($criteria);

			$entity = $q->getSingleResult();

			return $entity;
		
		} catch (\Doctrine\ORM\Query\QueryException $e) {
		
			throw new DAOException( $e->getMessage() );
			
		} catch (\Doctrine\ORM\NoResultException $e){

			throw new DAONoResultException($e->getMessage());
			
		} catch (\Doctrine\ORM\NonUniqueResultException $e){

			throw new DAONonUniqueResultException($e->getMessage());
			
		} catch (\Exception $e) {
			
			throw new DAOException( $e->getMessage() );
			
		}
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Cose\Crud\dao\ICrudDAO::addEntities()
	 */
	function addEntities( $entities, $batchSize=1000 ){
		
		$index = 0;
		
		foreach ($entities as $entity) {
			
			$index++;			
			
			$this->entityManager->persist($entity);
			
			if (($index % $batchSize) == 0) {
				$this->entityManager->flush();
				$this->entityManager->clear();
			}
		}	
		
		if (($index % $batchSize) != 0) {
			$this->entityManager->flush();
			$this->entityManager->clear();
		}
		
	}
}