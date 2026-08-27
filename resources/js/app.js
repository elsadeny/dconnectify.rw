const THEME_STORAGE_KEY = 'connectify-theme';

const getResolvedTheme = (themePreference) => {
	const hour = new Date().getHours();
	const isNight = hour >= 18 || hour < 7;

	if (themePreference === 'light' || themePreference === 'dark') {
		return themePreference;
	}

	if (themePreference === 'system') {
		return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
	}

	return isNight ? 'dark' : 'light';
};

const applyThemePreference = (themePreference) => {
	const resolvedTheme = getResolvedTheme(themePreference);

	document.documentElement.dataset.theme = themePreference;
	document.documentElement.classList.toggle('dark', resolvedTheme === 'dark');
	document.documentElement.style.colorScheme = resolvedTheme;

	document.querySelectorAll('[data-theme-choice]').forEach((button) => {
		const isActive = button.dataset.themeChoice === themePreference;

		button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
		button.classList.toggle('bg-white/15', isActive);
		button.classList.toggle('text-white', isActive);
		button.classList.toggle('border-white/30', isActive);
	});
};

const initializeThemeControls = () => {
	const savedTheme = localStorage.getItem(THEME_STORAGE_KEY) || 'auto';
	applyThemePreference(savedTheme);

	document.querySelectorAll('[data-theme-choice]').forEach((button) => {
		if (button.dataset.themeInitialized === 'true') {
			return;
		}

		button.addEventListener('click', () => {
			const nextTheme = button.dataset.themeChoice || 'auto';
			localStorage.setItem(THEME_STORAGE_KEY, nextTheme);
			applyThemePreference(nextTheme);
		});

		button.dataset.themeInitialized = 'true';
	});

	const systemThemeQuery = window.matchMedia('(prefers-color-scheme: dark)');
	systemThemeQuery.addEventListener?.('change', () => {
		if ((localStorage.getItem(THEME_STORAGE_KEY) || 'auto') === 'system') {
			applyThemePreference('system');
		}
	});
};

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

const LISTING_SLIDESHOW_MS = 10000;
const LISTING_ZOOM_SIZE = 168;
const LISTING_ZOOM_LEVEL = 2.35;

const getObjectCoverMetrics = (img) => {
	const rect = img.getBoundingClientRect();
	const displayW = rect.width;
	const displayH = rect.height;
	const naturalW = img.naturalWidth || displayW;
	const naturalH = img.naturalHeight || displayH;
	const scale = Math.max(displayW / naturalW, displayH / naturalH);
	const renderedW = naturalW * scale;
	const renderedH = naturalH * scale;

	return {
		rect,
		displayW,
		displayH,
		renderedW,
		renderedH,
		offsetX: (renderedW - displayW) / 2,
		offsetY: (renderedH - displayH) / 2,
	};
};

const canHoverZoom = () => window.matchMedia('(hover: hover) and (pointer: fine)').matches;

const initializeListingGallery = () => {
	document.querySelectorAll('[data-listing-gallery]').forEach((gallery) => {
		if (gallery.dataset.galleryInitialized === 'true') {
			return;
		}

		const preview = gallery.querySelector('[data-listing-preview]');
		const previewWrap = gallery.querySelector('[data-listing-preview-wrap]');
		const zoom = gallery.querySelector('[data-listing-zoom]');
		const thumbs = Array.from(gallery.querySelectorAll('[data-listing-thumb]'));
		const progress = gallery.querySelector('[data-listing-progress]');
		const progressTrack = gallery.querySelector('[data-listing-progress-track]');

		if (!preview) {
			return;
		}

		const sources = thumbs.map((thumb) => thumb.dataset.listingThumb).filter(Boolean);
		let currentIndex = Math.max(0, sources.indexOf(preview.getAttribute('src')));
		let slideshowActive = sources.length > 1;
		let slideshowPaused = false;
		let remainingMs = LISTING_SLIDESHOW_MS;
		let slideStartedAt = Date.now();
		let timer = null;

		const setActiveImage = (src) => {
			preview.src = src;
			currentIndex = Math.max(0, sources.indexOf(src));

			thumbs.forEach((thumb) => {
				const isActive = thumb.dataset.listingThumb === src;

				thumb.setAttribute('aria-pressed', isActive ? 'true' : 'false');
				thumb.classList.toggle('ring-[var(--color-ocean)]', isActive);
				thumb.classList.toggle('ring-transparent', !isActive);
			});
		};

		const clearTimer = () => {
			if (timer) {
				clearTimeout(timer);
				timer = null;
			}
		};

		const restartProgress = () => {
			if (!progress || !slideshowActive) {
				return;
			}

			progress.classList.remove('is-running', 'is-paused');
			void progress.offsetWidth;
			progress.classList.add('is-running');
		};

		const advanceSlide = () => {
			if (!slideshowActive || slideshowPaused) {
				return;
			}

			const nextIndex = (currentIndex + 1) % sources.length;
			setActiveImage(sources[nextIndex]);
			remainingMs = LISTING_SLIDESHOW_MS;
			slideStartedAt = Date.now();
			restartProgress();
			scheduleAdvance(LISTING_SLIDESHOW_MS);
		};

		const scheduleAdvance = (delay) => {
			clearTimer();
			timer = setTimeout(advanceSlide, delay);
		};

		const pauseSlideshow = () => {
			if (!slideshowActive || slideshowPaused) {
				return;
			}

			slideshowPaused = true;
			remainingMs = Math.max(0, remainingMs - (Date.now() - slideStartedAt));
			clearTimer();
			progress?.classList.add('is-paused');
		};

		const resumeSlideshow = () => {
			if (!slideshowActive || !slideshowPaused) {
				return;
			}

			slideshowPaused = false;
			slideStartedAt = Date.now();
			progress?.classList.remove('is-paused');
			scheduleAdvance(remainingMs);
		};

		const stopSlideshow = () => {
			slideshowActive = false;
			slideshowPaused = false;
			clearTimer();
			progress?.classList.remove('is-running', 'is-paused');
			progressTrack?.classList.add('is-stopped');
		};

		const hideZoom = () => {
			if (!zoom) {
				return;
			}

			zoom.hidden = true;
			zoom.classList.remove('is-visible');
		};

		const updateZoom = (event) => {
			if (!zoom || !canHoverZoom()) {
				hideZoom();
				return;
			}

			const metrics = getObjectCoverMetrics(preview);
			const x = Math.min(Math.max(event.clientX - metrics.rect.left, 0), metrics.displayW);
			const y = Math.min(Math.max(event.clientY - metrics.rect.top, 0), metrics.displayH);
			const lensX = Math.min(Math.max(x - LISTING_ZOOM_SIZE / 2, 8), Math.max(8, metrics.displayW - LISTING_ZOOM_SIZE - 8));
			const lensY = Math.min(Math.max(y - LISTING_ZOOM_SIZE / 2, 8), Math.max(8, metrics.displayH - LISTING_ZOOM_SIZE - 8));
			const backgroundX = (x + metrics.offsetX) * LISTING_ZOOM_LEVEL;
			const backgroundY = (y + metrics.offsetY) * LISTING_ZOOM_LEVEL;

			zoom.hidden = false;
			zoom.classList.add('is-visible');
			zoom.style.left = `${lensX}px`;
			zoom.style.top = `${lensY}px`;
			zoom.style.backgroundImage = `url("${preview.currentSrc}")`;
			zoom.style.backgroundSize = `${metrics.renderedW * LISTING_ZOOM_LEVEL}px ${metrics.renderedH * LISTING_ZOOM_LEVEL}px`;
			zoom.style.backgroundPosition = `${x - lensX - backgroundX}px ${y - lensY - backgroundY}px`;
		};

		if (previewWrap) {
			previewWrap.addEventListener('mouseenter', (event) => {
				pauseSlideshow();
				updateZoom(event);
			});
			previewWrap.addEventListener('mousemove', updateZoom);
			previewWrap.addEventListener('mouseleave', () => {
				hideZoom();
				resumeSlideshow();
			});
		}

		thumbs.forEach((thumb) => {
			thumb.addEventListener('click', () => {
				stopSlideshow();
				setActiveImage(thumb.dataset.listingThumb);
			});
		});

		if (slideshowActive) {
			slideStartedAt = Date.now();
			remainingMs = LISTING_SLIDESHOW_MS;
			restartProgress();
			scheduleAdvance(LISTING_SLIDESHOW_MS);
		}

		gallery.dataset.galleryInitialized = 'true';
	});
};

initializeCountryCityFilters();
initializeAsyncForms();
initializeThemeControls();
initializeListingGallery();
