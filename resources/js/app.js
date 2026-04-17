document.querySelectorAll('[data-country-city-filter]').forEach((form) => {
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
});
