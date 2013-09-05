<?php
namespace Cose\Crud\service;

use Cose\exception\ServiceException,
	Cose\service\IService;;

/**
 * Interface gen�rica para los servicios de abm
 * 
 * @author bernardo
 *
 */
interface ICrudService extends IService{

	/**
	 * se agrega una nueva entity
	 * @param entity entity a agregar.
	 * @throws ServiceException 
	 */
	function add( $entity );
	
	/**
	 * se modifica una entity
	 * @param entity entity a modificar.
	 * @throws ServiceException
	 */
	function update( $entity );
	
	/**
	 * se elimina una entity
	 * @param oid identificador de la entity a eliminar.
	 * @throws ServiceException
	 */
	function delete( $oid );
	
	/**
	 * obtiene la entity dado su identificador
	 * @param oid identificador de la entity a buscar.
	 * @return
	 * @throws ServiceException
	 */
	function get( $oid );
	
	/**
	 * obtiene el listado de entities dado un criterio de b�squeda.
	 * @param ICriteria criteria criterio de b�squeda.
	 * @return listado de entities
	 * @throws ServiceException
	 */
	function getList( $criteria );

	function getCount($criteria);
	
	/**
	 * obtiene una entity dado un criterio de b�squeda.
	 * @param ICriteria criteria criterio de b�squeda.
	 * @return entity
	 * @throws DAOException
	 */
	function getSingleResult( $criteria );
	
}