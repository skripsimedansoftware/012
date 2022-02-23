var callback_function = (...arguments) => {
	if (arguments !== undefined) {
		if (typeof arguments[0] == 'function') {
			arguments[0](...Array.prototype.slice.call(arguments, 1));
		} else {
			eval(arguments[0]+'(...Array.prototype.slice.call(arguments, 1))');
		}
	}
}

var base64_to_int8_array = (base64_string) => {
	const padding = '='.repeat((4 - base64_string.length % 4) % 4);
	const base64 = (base64_string + padding).replace(/\-/g, '+').replace(/_/g, '/');
	const rawData = window.atob(base64);
	const outputArray = new Uint8Array(rawData.length);

	for (let i = 0; i < rawData.length; ++i) {
		outputArray[i] = rawData.charCodeAt(i);
	}

	return outputArray;
}

var register = (callback) => {
	if ('serviceWorker' in navigator) {
		var service_worker = '/service-worker.js';
		navigator.serviceWorker.register(service_worker).then(async function(register) {
			var serviceWorker;
			if (register.installing) {
				serviceWorker = register.installing;
			} else if (register.waiting) {
				serviceWorker = register.waiting;
			} else if (register.active) {
				serviceWorker = register.active;
			}

			if (serviceWorker) {
				// service-worker already activated
				if (serviceWorker.state == 'activated') {
					callback_function(callback, register);
				}

				serviceWorker.addEventListener('statechange', async function(event) {
					// service-worker just activated
					if (event.target.state == 'activated') {
						callback_function(callback, register);
					}
				});
			}

			// service-worker has update
			register.addEventListener('updatefound', async () => {
				// just updated
				var new_udpate = register.installing;
				new_udpate.addEventListener('statechange', () => {
				});
			});
		});
	}
}

/**
 * public : BOpvsZbWYd0HISha1N4aDTLTrkCeIbQs-IouzyswJ5QKLMwPHNEfy9XWthCvlO7h3YDWvrTYVAmveYujMRUEfFU
 * private : LmJrS3QPlploI6TpueNPHLjNlhc8ayrAcXjoZ2j21Og
 */
register(async (sw) => {
	var subscribe_notification = await sw.pushManager.subscribe({
		userVisibleOnly: true,
		applicationServerKey: base64_to_int8_array('BOpvsZbWYd0HISha1N4aDTLTrkCeIbQs-IouzyswJ5QKLMwPHNEfy9XWthCvlO7h3YDWvrTYVAmveYujMRUEfFU')
	});
});
