/**
 * @author Champa
 */

'use strict';

const SERVER = 'http://localhost:';
var $thisClient;

/**
 * Kreira klijenta
 * @class
 */

var Client = function(port, clientid){
	this.socket = io.connect(SERVER + port, {transports: ['websocket']});
	//this.socket = io.connect(SERVER + port);

	console.log('Konektujem se na ' + SERVER + port);

	$thisClient = this;

	/**
	 * Prekinuta konekcija iz nekog razloga ?
	 * @param {string} greska
	 */

	$thisClient.socket.on('connect_failed', function(data){
		$thisClient.socket = io.connect(SERVER + port, {transports: ['websocket']});
		console.log(data);
	});

	/**
	 * Ugaseni serveri ?
	 * @param {string} greska
	 */

	$thisClient.socket.on('connect_error', function(data){
		$thisClient.socket = io.connect(SERVER + port, {transports: ['websocket']});
		console.log(data);
	});

	/**
	 * Server iskljucio klijenta ?
	 * @param {int} razlog iskljucenja
	 */

	$thisClient.socket.on('client_disconnect', function(data){
		console.log(data);
	});

	$thisClient.socket.emit('subChForUs', clientid);

	return this.socket;
}

Client.prototype = {
	test : function(){

	}
}
