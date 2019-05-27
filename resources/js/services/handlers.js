
export function getDataHandler(res) {
	if(res && res.data) {
		return res.data;
	}
	return undefined;
}

export function unauthorizedHandler(err) {
	if(err && err.response.status == 401) {
		if(localStorage.getItem('user')) {
			localStorage.removeItem('user');
		}
		location.reload();
	}
	return Promise.reject(err);
}

export function unprocessableEntityHandler(err) {
	if(err && err.response.status == 422) {
		return Promise.reject(err.response.data);
	}
	return Promise.reject(err);
}
