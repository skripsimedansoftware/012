/**
 * Codeigniter Service Worker
 *
 * @version 1.0.0
 * @package Codeigniter
 * @subpackage Service Worker
 * @author Agung Dirgantara <agungmasda29@gmail.com>
 *
 * Refrence :
 *
 * - https://developer.mozilla.org/en-US/docs/Web/API/Service_Worker_API/Using_Service_Workers (using service worker)
 * - https://developer.mozilla.org/en-US/docs/Web/API/ServiceWorkerGlobalScope (service worker global scope)
 * - https://developer.mozilla.org/en-US/docs/Web/API/notification (notification)
 *
 * - https://developers.google.com/web/fundamentals/primers/service-workers (web fundamentals - service worker)
 * - https://developers.google.com/web/updates/2015/05/notifying-you-of-changes-to-notifications#serviceworkerregistrationgetnotifications (change notification)
 * - https://firebase.google.com/docs/reference/admin/node/admin.messaging.WebpushNotification
 */

'use strict';

let app = {
	name :'Codeigniter',
	version : '1.0.0',
	base_url : 'SERVER_URL'
}

class FeedBack {
	constructor() {
		this.base_url = app.base_url;
	}

	async request(path = '', method = 'GET', data = {}) {
		return await fetch(this.base_url+path, {
			method: method, // *GET, POST, PUT, DELETE, etc.
			mode: 'cors', // no-cors, *cors, same-origin
			cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
			credentials: 'same-origin', // include, *same-origin, omit
			redirect: 'follow', // manual, *follow, error
			referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
			body: JSON.stringify(data) // body data type must match "Content-Type" header
		});
	}

	send(data) {
		this.request('/webpush/feedback', 'POST', data);
	}
}

var feedback = new FeedBack;
var is_valid_json = function(StrOrObject) {
	if (typeof StrOrObject == 'object') {
		return true;
	} else {
		try {
			var o = JSON.parse(StrOrObject);
			if (o && typeof o === "object") {
				return o;
			}
		} catch (e) {
			return false;
		}
	}
};

/**
 * install service worker
 */
self.addEventListener('install', event => {
	console.log('Installing '+app.name+' Service Worker Version : '+app.version);
	self.skipWaiting();
});

/**
 * Service worker activation
 */
self.addEventListener('activate', event => {
	clients.claim();
});

/**
 * listen push notification
 */
self.addEventListener('push', event => {

	if (is_valid_json(event.data.text())) {
		if (!(self.Notification && self.Notification.permission === 'granted')) {
			return;
		}

		var notification = JSON.parse(event.data.text());

		self.registration.showNotification(notification.title, notification.options);
		feedback.send({ event: 'received', notification: notification.options.data });
	}
});

/**
 * notification - onclick
 */
self.addEventListener('notificationclick', function(event) {
	event.notification.close();
	event.waitUntil(
		clients.matchAll({
			type: 'window'
	}).then(function(clientList) {
		for (var i = 0; i < clientList.length; i++) {
			var client = clientList[i];
			if (client.url == '/' && 'focus' in client) {
				return client.focus();
			}
		}

		if (event.action == '') {
			feedback.send({ event: 'clicked', notification: event.notification.data });
			if (clients.openWindow) {
				if (event.notification.data !== undefined && event.notification.data !== null) {
					if (event.notification.data.open_url !== undefined) {
						return clients.openWindow(event.notification.data.open_url);
					}
				}
			}
		} else {

			feedback.send({ event: 'clicked', action: event.action, notification: event.notification.data });
			switch (event.action) {
				case 'action1':
				break;

				case 'action2':
				break;

				default:
					event.notification.close();
				break;
			}
		}
	}));
});

/**
 * notification - onclose event
 */
self.addEventListener('notificationclose', function(event) {
	if (event.notification.data !== undefined) {
		feedback.send({ event: 'closed', notification: event.notification.data });
	}
});