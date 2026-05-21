const initializeCountryCityFilters = () => {
	document.querySelectorAll('[data-country-city-filter]').forEach((form) => {
		if (form.dataset.countryCityInitialized === 'true') {
			return;
		}

		const countrySelect = form.querySelector('[data-country-select]');
		const citySelect = form.querySelector('[data-city-select]');

		if (!countrySelect || !citySelect) {
			return;
		}

		const countryCityMap = JSON.parse(form.dataset.countryCityMap ?? '{}');

		const renderCities = (country, selectedCity = '') => {
			const cities = country ? countryCityMap[country] ?? {} : {};

			citySelect.innerHTML = '';

			const placeholder = document.createElement('option');
			placeholder.value = '';
			placeholder.textContent = country ? 'All cities' : 'Choose country first';
			citySelect.appendChild(placeholder);

			Object.entries(cities).forEach(([value, label]) => {
				const option = document.createElement('option');
				option.value = value;
				option.textContent = label;
				option.selected = value === selectedCity;
				citySelect.appendChild(option);
			});

			citySelect.disabled = !country;

			if (!cities[selectedCity]) {
				citySelect.value = '';
			}
		};

		renderCities(countrySelect.value, citySelect.value);

		countrySelect.addEventListener('change', () => {
			renderCities(countrySelect.value);
		});

		form.dataset.countryCityInitialized = 'true';
	});
};

const isSameOriginUrl = (url) => {
	try {
		const parsed = new URL(url, window.location.href);
		return parsed.origin === window.location.origin;
	} catch {
		return false;
	}
};

const initializeAsyncForms = () => {
	document.querySelectorAll('form[data-async-form]').forEach((form) => {
		if (form.dataset.asyncInitialized === 'true') {
			return;
		}

		form.addEventListener('submit', async (event) => {
			event.preventDefault();

			const targetSelector = form.dataset.asyncTarget;

			if (!targetSelector) {
				form.submit();
				return;
			}

			const method = (form.method || 'GET').toUpperCase();

			if (method !== 'GET') {
				form.submit();
				return;
			}

			const action = form.action || window.location.href;
			const url = new URL(action, window.location.href);
			const params = new URLSearchParams(new FormData(form));
			url.search = params.toString();

			await refreshAsyncContainer({
				url: url.toString(),
				targetSelector,
				pushState: form.dataset.asyncPushState !== 'false',
			});
		});

		form.dataset.asyncInitialized = 'true';
	});
};

const refreshAsyncContainer = async ({
	url,
	targetSelector,
	pushState = true,
}) => {
	const target = document.querySelector(targetSelector);

	if (!target) {
		return;
	}

	target.classList.add('opacity-60', 'pointer-events-none');
	target.setAttribute('aria-busy', 'true');

	try {
		const response = await fetch(url, {
			headers: {
				'X-Requested-With': 'XMLHttpRequest',
			},
		});

		if (!response.ok) {
			window.location.href = url;
			return;
		}

		const html = await response.text();
		const parser = new DOMParser();
		const doc = parser.parseFromString(html, 'text/html');
		const nextTarget = doc.querySelector(targetSelector);

		if (!nextTarget) {
			window.location.href = url;
			return;
		}

		target.replaceWith(nextTarget);
		initializeCountryCityFilters();
		initializeAsyncForms();

		if (pushState) {
			window.history.pushState({}, '', url);
		}
	} catch {
		window.location.href = url;
	} finally {
		const currentTarget = document.querySelector(targetSelector);

		if (currentTarget) {
			currentTarget.classList.remove('opacity-60', 'pointer-events-none');
			currentTarget.removeAttribute('aria-busy');
		}
	}
};

document.addEventListener('click', async (event) => {
	const link = event.target.closest('a[href]');

	if (!link || !isSameOriginUrl(link.href)) {
		return;
	}

	const container = link.closest('[data-async-container]');

	if (!container) {
		return;
	}

	const url = new URL(link.href, window.location.href);

	if (url.pathname !== window.location.pathname || !url.searchParams.has('page')) {
		return;
	}

	event.preventDefault();

	await refreshAsyncContainer({
		url: url.toString(),
		targetSelector: `#${container.id}`,
		pushState: true,
	});
});

document.addEventListener('click', async (event) => {
	const link = event.target.closest('a[data-async-link][href]');

	if (!link || !isSameOriginUrl(link.href)) {
		return;
	}

	const targetSelector = link.dataset.asyncTarget;

	if (!targetSelector) {
		return;
	}

	const url = new URL(link.href, window.location.href);
	const currentUrl = new URL(window.location.href);

	if (url.pathname !== currentUrl.pathname) {
		return;
	}

	event.preventDefault();

	await refreshAsyncContainer({
		url: url.toString(),
		targetSelector,
		pushState: link.dataset.asyncPushState !== 'false',
	});
});

initializeCountryCityFilters();
initializeAsyncForms();
