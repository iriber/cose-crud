<?php
namespace Cose\Crud\dao;

use Cose\exception\DAOException;

/**
 * Interface para los DAO Crud
 *  
 * @author bernardo
 *
 */
interface ICrudDAO {


	/**
	 * se agrega una nueva entity
	 * @param entity entity a agregar.
	 * @throws DAOException
	 */
	function add( $entity );
	
	/**
	 * se modifica una entity
	 * @param entity entity a modificar.
	 * @throws DAOException
	 */
	function update( $entity );
	
	/**
	 * se elimina una entity
	 * @param oid identificador de la entity a eliminar.
	 * @throws DAOException
	 */
	function delete( $oid );
	
	/**
	 * obtiene la entity dado su identificador
	 * @param oid identificador de la entity a buscar.
	 * @return
	 * @throws DAOException
	 */
	function get( $oid );
	
	/**
	 * obtiene el listado de entities dado un criterio de b�squeda.
	 * @param ICriteria criteria criterio de b�squeda.
	 * @return listado de entities
	 * @throws DAOException
	 */
	function getList( $criteria );
	
	/**
	 * obtiene la cantidad de entities dado un criterio de búsqueda.
	 * @param ICriteria criteria criterio de búsqueda.
	 * @return int cantidad
	 * @throws DAOException
	 */
	function getCount( $criteria );
	
	/**
	 * obtiene una entity dado un criterio de b�squeda.
	 * @param ICriteria criteria criterio de b�squeda.
	 * @return entity
	 * @throws DAOException
	 */
	function getSingleResult( $criteria );

	/**
	 * agrega varias entities en modo batch
	 * @param array $entities
	 * @param integer $batchSize
	 */
	function addEntities( $entities, $batchSize=1000 );
}
