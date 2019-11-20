/*! KeyTable 1.2.0
 * ©2010-2014 SpryMedia Ltd - datatables.net/license
 */

/**
 * @summary     KeyTable
 * @description Spreadsheet like keyboard navigation for DataTables
 * @version     1.2.0
 * @file        dataTables.keyTable.js
 * @author      SpryMedia Ltd (www.sprymedia.co.uk)
 * @contact     www.sprymedia.co.uk/contact
 * @copyright   Copyright 2009-2014 SpryMedia Ltd.
 *
 * This source file is free software, available under the following license:
 *   MIT license - http://datatables.net/license/mit
 *
 * This source file is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE. See the license files for details.
 *
 * For details please refer to: http://www.datatables.net
 */

// Global scope for KeyTable for backwards compatibility. Will be removed in 1.3
var KeyTable;


(function(window, document, undefined) {


var factory = function( $, DataTable ) {
"use strict";

KeyTable = function ( oInit )
{
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * API parameters
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

	/*
	 * Variable: block
	 * Purpose:  Flag whether or not KeyTable events should be processed
	 * Scope:    KeyTable - public
	 */
	this.block = false;

	/*
	 * Variable: event
	 * Purpose:  Container for all event application methods
	 * Scope:    KeyTable - public
	 * Notes:    This object contains all the public methods for adding and removing events - these
	 *           are dynamically added later on
	 */
	this.event = {
		"remove": {}
	};


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * API methods
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

	/*
	 * Function: fnGetCurrentPosition
	 * Purpose:  Get the currently focused cell's position
	 * Returns:  array int: [ x, y ]
	 * Inputs:   void
	 */
	this.fnGetCurrentPosition = function ()
	{
		return [ _iOldX, _iOldY ];
	};


	/*
	 * Function: fnGetCurrentData
	 * Purpose:  Get the currently focused cell's data (innerHTML)
	 * Returns:  string: - data requested
	 * Inputs:   void
	 */
	this.fnGetCurrentData = function ()
	{
		return _nOldFocus.innerHTML;
	};


	/*
	 * Function: fnGetCurrentTD
	 * Purpose:  Get the currently focused cell
	 * Returns:  node: - focused element
	 * Inputs:   void
	 */
	this.fnGetCurrentTD = function ()
	{
		return _nOldFocus;
	};


	/*
	 * Function: fnSetPosition
	 * Purpose:  Set the position of the focused cell
	 * Returns:  -
	 * Inputs:   int:x - x coordinate
	 *           int:y - y coordinate
	 * Notes:    Thanks to Rohan Daxini for the basis of this function
	 */
	this.fnSetPosition = function( x, y )
	{
		if ( typeof x == 'object' && x.nodeName )
		{
			_fnSetFocus( x );
		}
		else
		{
			_fnSetFocus( _fnCellFromCoords(x, y) );
		}
	};


	/*
	 * Function: fnBlur
	 * Purpose:  Blur the current focus
	 * Returns:  -
	 * Inputs:   -
	 */
	this.fnBlur = function()
	{
		_fnBlur();
	};


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Private parameters
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

	/*
	 * Variable: _nBody
	 * Purpose:  Body node of the table - cached for renference
	 * Scope:    KeyTable - private
	 */
	var _nBody = null;

	/*
	 * Variable: 
	 * Purpose:  
	 * Scope:    KeyTable - private
	 */
	var _nOldFocus = null;

	/*
	 * Variable: _iOldX and _iOldY
	 * Purpose:  X and Y coords of the old elemet that was focused on
	 * Scope:    KeyTable - private
	 */
	var _iOldX = null;
	var _iOldY = null;

	/*
	 * Variable: _that
	 * Purpose:  Scope saving for 'this' after a jQuery event
	 * Scope:    KeyTable - private
	 */
	var _that = null;

	/*
	 * Variable: sFocusClass
	 * Purpose:  Class that should be used for focusing on a cell
	 * Scope:    KeyTable - private
	 */
	var _sFocusClass = "focus";

	/*
	 * Variable: _bKeyCapture
	 * Purpose:  Flag for should KeyTable capture key events or not
	 * Scope:    KeyTable - private
	 */
	var _bKeyCapture = false;

	/*
	 * Variable: _oaoEvents
	 * Purpose:  Event cache object, one array for each supported event for speed of searching
	 * Scope:    KeyTable - private
	 */
	var _oaoEvents = {
		"action": [],
		"esc": [],
		"focus": [],
		"blur": []
	};

	/*
	 * Variable: _oDatatable
	 * Purpose:  DataTables settings object for if we are actually using a 
	 *           DataTables table
	 * Scope:    KeyTable - private
	 */
	var _oDatatable = null;

	var _bForm;
	var _nInput;
	var _bInputFocused = false;


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Private methods
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Key table events
	 */

	/*
	 * Function: _fnEventAddTemplate
	 * Purpose:  Create a function (with closure for sKey) event addition API
	 * Returns:  function: - template function
	 * Inputs:   string:sKey - type of event to detect
	 */
	function _fnEventAddTemplate( sKey )
	{
		/*
		 * Function: -
		 * Purpose:  API function for adding event to cache
		 * Returns:  -
		 * Inputs:   1. node:x - target node to add event for
		 *           2. function:y - callback function to apply
		 *         or
		 *           1. int:x - x coord. of target cell (can be null for live events)
		 *           2. int:y - y coord. of target cell (can be null for live events)
		 *           3. function:z - callback function to apply
		 * Notes:    This function is (interally) overloaded (in as much as javascript allows for
		 *           that) - the target cell can be given by either node or coords.
		 */
		return function ( x, y, z ) {
			if ( (x===null || typeof x == "number") &&
				 (y===null || typeof y == "number") &&
				 typeof z == "function" )
			{
				_fnEventAdd( sKey, x, y, z );
			}
			else if ( typeof x == "object" && typeof y == "function" )
			{
				var aCoords = _fnCoordsFromCell( x );
				_fnEventAdd( sKey, aCoords[0], aCoords[1], y );
			}
			else
			{
				alert( "Unhandable event type was added: x" +x+ "  y:" +y+ "  z:" +z );
			}
		};
	}


	/*
	 * Function: _fnEventRemoveTemplate
	 * Purpose:  Create a function (with closure for sKey) event removal API
	 * Returns:  function: - template function
	 * Inputs:   string:sKey - type of event to detect
	 */
	function _fnEventRemoveTemplate( sKey )
	{
		/*
		 * Function: -
		 * Purpose:  API function for removing event from cache
		 * Returns:  int: - number of events removed
		 * Inputs:   1. node:x - target node to remove event from
		 *           2. function:y - callback function to apply
		 *         or
		 *           1. int:x - x coord. of target cell (can be null for live events)
		 *           2. int:y - y coord. of target cell (can be null for live events)
		 *           3. function:z - callback function to remove - optional
		 * Notes:    This function is (interally) overloaded (in as much as javascript allows for
		 *           that) - the target cell can be given by either node or coords and the function
		 *           to remove is optional
		 */
		return function ( x, y, z ) {
			if ( (x===null || typeof arguments[0] == "number") &&
				 (y===null || typeof arguments[1] == "number" ) )
			{
				if ( typeof arguments[2] == "function" )
				{
					_fnEventRemove( sKey, x, y, z );
				}
				else
				{
					_fnEventRemove( sKey, x, y );
				}
			}
			else if ( typeof arguments[0] == "object" )
			{
				var aCoords = _fnCoordsFromCell( x );
				if ( typeof arguments[1] == "function" )
				{
					_fnEventRemove( sKey, aCoords[0], aCoords[1], y );
				}
				else
				{
					_fnEventRemove( sKey, aCoords[0], aCoords[1] );
				}
			}
			else
			{
				alert( "Unhandable event type was removed: x" +x+ "  y:" +y+ "  z:" +z );
			}
		};
	}

	/* Use the template functions to add the event API functions */
	for ( var sKey in _oaoEvents )
	{
		if ( sKey )
		{
			this.event[sKey] = _fnEventAddTemplate( sKey );
			this.event.remove[sKey] = _fnEventRemoveTemplate( sKey );
		}
	}


	/*
	 * Function: _fnEventAdd
	 * Purpose:  Add an event to the internal cache
	 * Returns:  -
	 * Inputs:   string:sType - type of event to add, given by the available elements in _oaoEvents
	 *           int:x - x-coords to add event to - can be null for "blanket" event
	 *           int:y - y-coords to add event to - can be null for "blanket" event
	 *           function:fn - callback function for when triggered
	 */
	function _fnEventAdd( sType, x, y, fn )
	{
		_oaoEvents[sType].push( {
			"x": x,
			"y": y,
			"fn": fn
		} );
	}


	/*
	 * Function: _fnEventRemove
	 * Purpose:  Remove an event from the event cache
	 * Returns:  int: - number of matching events removed
	 * Inputs:   string:sType - type of event to look for
	 *           node:nTarget - target table cell
	 *           function:fn - optional - remove this function. If not given all handlers of this
	 *             type will be removed
	 */
	function _fnEventRemove( sType, x, y, fn )
	{
		var iCorrector = 0;

		for ( var i=0, iLen=_oaoEvents[sType].length ; i<iLen-iCorrector ; i++ )
		{
			if ( typeof fn != 'undefined' )
			{
				if ( _oaoEvents[sType][i-iCorrector].x == x &&
					 _oaoEvents[sType][i-iCorrector].y == y &&
					   _oaoEvents[sType][i-iCorrector].fn == fn )
				{
					_oaoEvents[sType].splice( i-iCorrector, 1 );
					iCorrector++;
				}
			}
			else
			{
				if ( _oaoEvents[sType][i-iCorrector].x == x &&
					 _oaoEvents[sType][i-iCorrector].y == y )
				{
					_oaoEvents[sType].splice( i, 1 );
					return 1;
				}
			}
		}
		return iCorrector;
	}


	/*
	 * Function: _fnEventFire
	 * Purpose:  Look thought the events cache and fire off the event of interest
	 * Returns:  int:iFired - number of events fired
	 * Inputs:   string:sType - type of event to look for
	 *           int:x - x coord of cell
	 *           int:y - y coord of  ell
	 * Notes:    It might be more efficient to return after the first event has been tirggered,
	 *           but that would mean that only one function of a particular type can be
	 *           subscribed to a particular node.
	 */
	function _fnEventFire ( sType, x, y )
	{
		var iFired = 0;
		var aEvents = _oaoEvents[sType];
		for ( var i=0 ; i<aEvents.length ; i++ )
		{
			if ( (aEvents[i].x == x     && aEvents[i].y == y    ) ||
				 (aEvents[i].x === null && aEvents[i].y == y    ) ||
				 (aEvents[i].x == x     && aEvents[i].y === null ) ||
				 (aEvents[i].x === null && aEvents[i].y === null )
			)
			{
				aEvents[i].fn( _fnCellFromCoords(x,y), x, y );
				iFired++;
			}
		}
		return iFired;
	}



	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Focus functions
	 */

	/*
	 * Function: _fnSetFocus
	 * Purpose:  Set focus on a node, and remove from an old node if needed
	 * Returns:  -
	 * Inputs:   node:nTarget - node we want to focus on
	 *           bool:bAutoScroll - optional - should we scroll the view port to the display
	 */
	function _fnSetFocus( nTarget, bAutoScroll )
	{
		/* If node already has focus, just ignore this call */
		if ( _nOldFocus == nTarget )
		{
			return;
		}

		if ( typeof bAutoScroll == 'undefined' )
		{
			bAutoScroll = true;
		}

		/* Remove old focus (with blur event if needed) */
		if ( _nOldFocus !== null )
		{
			_fnRemoveFocus( _nOldFocus );
		}

		/* Add the new class to highlight the focused cell */
		$(nTarget).addClass( _sFocusClass );
		$(nTarget).parent().addClass( _sFocusClass );

		/* If it's a DataTable then we need to jump the paging to the relevant page */
		var oSettings;
		if ( _oDatatable )
		{
			oSettings = _oDatatable;
			var iRow = _fnFindDtCell( nTarget )[1];
			var bKeyCaptureCache = _bKeyCapture;

			/* Page forwards */
			while ( iRow >= oSettings.fnDisplayEnd() )
			{
				if ( oSettings._iDisplayLength >= 0 )
				{
					/* Make sure we are not over running the display array */
					if ( oSettings._iDisplayStart + oSettings._iDisplayLength < oSettings.fnRecordsDisplay() )
					{
						oSettings._iDisplayStart += oSettings._iDisplayLength;
					}
				}
				else
				{
					oSettings._iDisplayStart = 0;
				}
				_oDatatable.oApi._fnCalculateEnd( oSettings );
			}

			/* Page backwards */
			while ( iRow < oSettings._iDisplayStart )
			{
				oSettings._iDisplayStart = oSettings._iDisplayLength>=0 ?
					oSettings._iDisplayStart - oSettings._iDisplayLength :
					0;

				if ( oSettings._iDisplayStart < 0 )
				{
				  oSettings._iDisplayStart = 0;
				}
				_oDatatable.oApi._fnCalculateEnd( oSettings );
			}

			/* Re-draw the table */
			_oDatatable.oApi._fnDraw( oSettings );

			/* Restore the key capture */
			_bKeyCapture = bKeyCaptureCache;
		}

		/* Cache the information that we are interested in */
		var aNewPos = _fnCoordsFromCell( nTarget );
		_nOldFocus = nTarget;
		_iOldX = aNewPos[0];
		_iOldY = aNewPos[1];

		var iViewportHeight, iViewportWidth, iScrollTop, iScrollLeft, iHeight, iWidth, aiPos;
		if ( bAutoScroll )
		{
			/* Scroll the viewport such that the new cell is fully visible in the rendered window */
			iViewportHeight = $(window).height();
			iViewportWidth = $(window).width();
			iScrollTop = $(document).scrollTop();
			iScrollLeft = $(document).scrollLeft();
			iHeight = nTarget.offsetHeight;
			iWidth = nTarget.offsetWidth;
			aiPos = _fnGetPos( nTarget );

			/* Take account of scrolling in DataTables 1.7 - remove scrolling since that would add to
			 * the positioning calculation
			 */
			if ( _oDatatable && typeof oSettings.oScroll != 'undefined' &&
			  (oSettings.oScroll.sX !== "" || oSettings.oScroll.sY !== "") )
			{
				aiPos[1] -= $(oSettings.nTable.parentNode).scrollTop();
				aiPos[0] -= $(oSettings.nTable.parentNode).scrollLeft();
			}

			/* Correct viewport positioning for vertical scrolling */
			if ( aiPos[1]+iHeight > iScrollTop+iViewportHeight )
			{
				/* Displayed element if off the bottom of the viewport */
				_fnSetScrollTop( aiPos[1]+iHeight - iViewportHeight );
			}
			else if ( aiPos[1] < iScrollTop )
			{
				/* Displayed element if off the top of the viewport */
				_fnSetScrollTop( aiPos[1] );
			}

			/* Correct viewport positioning for horizontal scrolling */
			if ( aiPos[0]+iWidth > iScrollLeft+iViewportWidth )
			{
				/* Displayed element is off the bottom of the viewport */
				_fnSetScrollLeft( aiPos[0]+iWidth - iViewportWidth );
			}
			else if ( aiPos[0] < iScrollLeft )
			{
				/* Displayed element if off the Left of the viewport */
				_fnSetScrollLeft( aiPos[0] );
			}
		}

		/* Take account of scrolling in DataTables 1.7 */
		if ( _oDatatable && typeof oSettings.oScroll != 'undefined' &&
		  (oSettings.oScroll.sX !== "" || oSettings.oScroll.sY !== "") )
		{
			var dtScrollBody = oSettings.nTable.parentNode;
			iViewportHeight = dtScrollBody.clientHeight;
			iViewportWidth = dtScrollBody.clientWidth;
			iScrollTop = dtScrollBody.scrollTop;
			iScrollLeft = dtScrollBody.scrollLeft;
			iHeight = nTarget.offsetHeight;
			iWidth = nTarget.offsetWidth;

			/* Correct for vertical scrolling */
			if ( nTarget.offsetTop + iHeight > iViewportHeight+iScrollTop )
			{
				dtScrollBody.scrollTop = (nTarget.offsetTop + iHeight) - iViewportHeight;
			}
			else if ( nTarget.offsetTop < iScrollTop )
			{
				dtScrollBody.scrollTop = nTarget.offsetTop;
			}

			/* Correct for horizontal scrolling */
			if ( nTarget.offsetLeft + iWidth > iViewportWidth+iScrollLeft )
			{
				dtScrollBody.scrollLeft = (nTarget.offsetLeft + iWidth) - iViewportWidth;
			}
			else 