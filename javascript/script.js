/**
 * The JavaScript code you place here will be processed by esbuild, and the
 * output file will be created at `../theme/js/script.min.js` and enqueued by
 * default in `../theme/functions.php`.
 *
 * For esbuild documentation, please see:
 * https://esbuild.github.io/
 */

// create a event listener on click
document.addEventListener('click', function (event) {
	// Navigation for link-tiles linktiles
	// when clicked, check if the target has the class of link-tile or is nested inside of a link-tile
	if (
		event.target.classList.contains('link-tile') ||
		event.target.closest('.link-tile')
	) {
		let linkTile = event.target.closest('.link-tile');
		// get the url of the first a tag inside of the link-tile
		const url = linkTile.querySelector('a').href;
		// navigate to the url
		if (url) {
			window.location = url;
		}
	}
	if (event.target.id === 'close-search-overlay') {
		closeSearchBar();
	}
});

// Toggle the filter menu on mobile for blog page
const filterMenuButton = document.querySelector('#toggle-filter-menu');
const filterMenu = document.querySelector('#filter-menu');
if (filterMenuButton && filterMenu) {
	filterMenuButton.addEventListener('click', () => {
		const isExpanded =
			filterMenuButton.getAttribute('aria-expanded') === 'true';

		// Toggle aria-expanded
		filterMenuButton.setAttribute('aria-expanded', !isExpanded);

		// Show or hide the menu
		filterMenu.classList.toggle('hidden');

		// Optional: manage focus
		if (!isExpanded) {
			filterMenu.querySelector('a').focus();
		} else {
			filterMenuButton.focus();
		}
	});
}

// MOBILE NAV MENU
// Toggle the navigation menu on mobile
const navMenuButton = document.querySelector('#toggle-nav-menu');
const navigationContainer = document.getElementById('mobile-nav-container');
let activeSubMenu = null;
let currentSubButton = null;

function setNavigationAttributes(isOpen) {
	const status = isOpen ? 'true' : 'false';
	navMenuButton.setAttribute('aria-pressed', status);
	setTimeout(() => {
		navigationContainer.setAttribute('aria-expanded', status);
	}, 50);
	if (isOpen) {
		navigationContainer.removeAttribute('aria-hidden');
	} else {
		navigationContainer.setAttribute('aria-hidden', 'true');
	}
	resetMobileNav();
}

// Handle the Escape key
function handleEscape(event) {
	if (event.key === 'Escape' || event.keyCode === 27) {
		if (navMenuButton.getAttribute('aria-pressed') === 'true') {
			setNavigationAttributes(false);
			document.removeEventListener('keydown', handleEscape);
		}
	}
}

// Toggle the navigation menu on mobile
if (navMenuButton) {
	navMenuButton.addEventListener('click', () => {
		const isOpen = navMenuButton.getAttribute('aria-pressed') === 'true';
		setNavigationAttributes(!isOpen);

		if (!isOpen) {
			// Menu is being opened, so add the Escape key listener
			document.addEventListener('keydown', handleEscape);
			document.body.classList.add('overflow-hidden');
			document
				.getElementById('header-header')
				.classList.add('bg-d64gray-50');
		} else {
			// Menu is being closed, so remove the Escape key listener
			document.removeEventListener('keydown', handleEscape);
			document.body.classList.remove('overflow-hidden');
			document
				.getElementById('header-header')
				.classList.remove('bg-d64gray-50');
		}
	});
}

// mobile navigation menu functionality
document.addEventListener('click', function (event) {
	if (
		event.target.classList.contains('mobile-nav-button') ||
		event.target.closest('.mobile-nav-button')
	) {
		activeSubMenu = event.target.closest('.mobile-nav-button').dataset.id;
		currentSubButton = event.target.closest('.mobile-nav-button');
		event.target.setAttribute('aria-expanded', 'true');
		changeNavHeadline(activeSubMenu);
		displaySubMenu(activeSubMenu);
		toggleTopLevelNav('hide');
	} else if (event.target.id === 'submenu-nav-button') {
		resetMobileNav();
	}
});

// reset Mobile Nav
function resetMobileNav() {
	activeSubMenu = null;
	changeNavHeadline('NAVIGATION');
	toggleTopLevelNav('display');
	hideAllSubMenus();
	if (currentSubButton) {
		currentSubButton.setAttribute('aria-expanded', 'false');
	}
}

// change the headline of the mobile nav
function changeNavHeadline(newHeadline) {
	let navHeadline = document.querySelector('#nav-headline');
	navHeadline.innerHTML = newHeadline.toUpperCase();
}

// display sub menu
function displaySubMenu(subMenu) {
	// select element with data-id subMenu
	let subMenuElement = document.getElementById(subMenu);
	subMenuElement.classList.remove('hidden');
	subMenuElement.classList.add('flex');
	document.getElementById('sub-nav-btn-container').classList.remove('hidden');
	document.getElementById('sub-nav-btn-container').classList.add('flex');
	document.getElementById('main-logo').classList.add('opacity-0');
	document.getElementById('main-logo').classList.add('pointer-events-none');
}

// hide all sub menus
function hideAllSubMenus() {
	console.log('hide all sub menus');
	let subMenus = document.querySelectorAll('.mobile-nav-sub-menu');
	if (subMenus.length === 0) return;
	subMenus.forEach((subMenu) => {
		subMenu.classList.remove('flex');
		subMenu.classList.add('hidden');
	});
	document.getElementById('sub-nav-btn-container').classList.remove('flex');
	document.getElementById('sub-nav-btn-container').classList.add('hidden');
	document.getElementById('main-logo').classList.remove('opacity-0');
	document
		.getElementById('main-logo')
		.classList.remove('pointer-events-none');
}

// hide the top level navigation when button is pressed
function toggleTopLevelNav(status) {
	let topLevelNav = document.querySelector('#top-level-nav');
	if (status === 'hide') {
		topLevelNav.classList.add('hidden');
		topLevelNav.classList.remove('flex');
	} else if (status === 'display') {
		topLevelNav.classList.add('flex');
		topLevelNav.classList.remove('hidden');
	}
}

// DESKTOP NAV MENU
let navButtons = document.querySelectorAll('.desktop-nav-btn');
if (navButtons) {
	navButtons.forEach((button) => {
		button.addEventListener('click', function () {
			let expanded = this.getAttribute('aria-expanded') === 'true';

			// If the current submenu is expanded, collapse it and return
			if (expanded) {
				this.setAttribute('aria-expanded', 'false');
				let navMenu = document.getElementById(button.dataset.id);
				navMenu.classList.remove('flex');
				navMenu.classList.add('hidden');
				navMenu.setAttribute('aria-hidden', 'true');
				return;
			}

			// First, close all open submenus except the current one
			closeAllSubMenus(this);

			// Then, open the intended submenu
			this.setAttribute('aria-expanded', 'true');
			let navMenu = document.getElementById(button.dataset.id);
			navMenu.classList.remove('hidden');
			navMenu.classList.add('flex');
			setTimeout(() => {
				navMenu.setAttribute('aria-hidden', 'false');
			}, 20);
		});
	});
}

function closeAllSubMenus(exceptButton) {
	navButtons.forEach((button) => {
		if (button === exceptButton) return; // Skip the button that's currently being clicked

		let navMenu = document.getElementById(button.dataset.id);
		navMenu.classList.remove('flex');
		navMenu.classList.add('hidden');
		button.setAttribute('aria-expanded', 'false');
	});
}

// Add padding to the #header-content to account for the fixed header
document.addEventListener('DOMContentLoaded', function () {
	if (
		document.getElementById('header-content') &&
		document.getElementById('wpadminbar')
	) {
		const padding = document.getElementById('wpadminbar').offsetHeight;
		document.getElementById('header-content').style.paddingTop =
			padding + 'px';
		if (navigationContainer) {
			navigationContainer.style.marginTop = padding + 'px';
		}
	}
});

// Full page search

// Get references to the elements
const toggleSearchBtn = document.getElementById('toggle-search-bar-btn');
const fullPageSearch = document.getElementById('full-page-search');

if (toggleSearchBtn && fullPageSearch) {
	// Add event listener to the button
	toggleSearchBtn.addEventListener('click', function () {
		// Check current state
		let isExpanded = this.getAttribute('aria-expanded') === 'true';

		// Toggle visibility of the search bar
		if (isExpanded) {
			fullPageSearch.style.display = 'none';
		} else {
			fullPageSearch.style.display = 'block';

			// (Optional) Focus the search input when it's shown
			const searchInput = fullPageSearch.querySelector('#search');
			if (searchInput) {
				searchInput.focus();
			}
		}

		// Update aria-expanded attribute
		this.setAttribute('aria-expanded', !isExpanded);

		// Listen for escape key
		document.addEventListener('keydown', function (event) {
			if (event.key === 'Escape' || event.keyCode === 27) {
				closeSearchBar();
			}
		});
	});
}

// Close search bar logic
const closeSearchBarBtn = document.getElementById('close-search-bar');
if (closeSearchBarBtn) {
	closeSearchBarBtn.addEventListener('click', () => closeSearchBar());
}

function closeSearchBar() {
	// remove the value from the search input
	fullPageSearch.querySelector('#search').value = '';
	fullPageSearch.style.display = 'none';
	toggleSearchBtn.setAttribute('aria-expanded', 'false');
	let searchResultOverlay = document.getElementById('search-result-overlay');
	if (searchResultOverlay) {
		searchResultOverlay.classList.add('hidden');
		searchResultOverlay.classList.remove('fixed');
	}
}

// Tabs
const tabButtons = document.querySelectorAll('.tab-selector__button');
const tabContents = document.querySelectorAll('.tab-content__item');

if (tabButtons.length && tabContents) {
	// Initialize
	tabButtons[0].setAttribute('aria-pressed', 'true');
	tabButtons[0].classList.remove('border-d64blue-50');
	tabButtons[0].classList.add('border-d64blue-900');
	tabContents[0].classList.remove('hidden');
	tabContents[0].classList.add('block');

	tabButtons.forEach((button) => {
		button.addEventListener('click', (event) => {
			const tabId = event.target.getAttribute('data-tab-id');

			// Update aria-pressed and hide all tabs
			tabButtons.forEach((button) =>
				button.setAttribute('aria-pressed', 'false')
			);
			tabButtons.forEach((button) => {
				if (button.classList.contains('border-d64blue-900')) {
					button.classList.remove('border-d64blue-900');
					button.classList.add('border-d64blue-50');
				}
			});
			tabContents.forEach((content) => content.classList.remove('block'));
			tabContents.forEach((content) => {
				if (!content.classList.contains('hidden')) {
					content.classList.add('hidden');
				}
			});

			// Show the clicked tab and set aria-pressed to true
			document
				.getElementById(`tab-content-${tabId}`)
				.classList.remove('hidden');
			document
				.getElementById(`tab-content-${tabId}`)
				.classList.add('block');
			document
				.getElementById(`tab-button-${tabId}`)
				.classList.remove('border-d64blue-50');
			document
				.getElementById(`tab-button-${tabId}`)
				.classList.add('border-d64blue-900');
			document
				.getElementById(`tab-button-${tabId}`)
				.setAttribute('aria-pressed', 'true');
		});
	});
}

// KI Wertekompass
document.addEventListener('DOMContentLoaded', function () {
	const sliders = document.querySelectorAll('input[type="range"]');
	console.log(sliders ? 'found sliders' : 'no sliders');

	sliders.forEach((slider) => {
		updateThumbPosition(slider);
		slider.addEventListener('input', function () {
			updateThumbPosition(this);
		});
	});

	// Add resize listener
	window.addEventListener('resize', function () {
		sliders.forEach((slider) => {
			updateThumbPosition(slider);
		});
	});

	document
		.getElementById('downloadBtn')
		.addEventListener('click', downloadImage);
});

function updateThumbPosition(slider) {
	const thumb = slider.previousElementSibling.querySelector('.slider-thumb');
	const sliderWidth = slider.offsetWidth;
	const thumbWidth = 32;
	const offset = thumbWidth / 2;
	const availableWidth = sliderWidth - thumbWidth;
	const value = parseInt(slider.value);
	const position = (value / 100) * availableWidth + offset;
	thumb.style.left = `${position}px`;
}

function downloadImage() {
	const container = document.getElementById('slider-container');
	const downloadBtn = document.getElementById('downloadBtn');
	downloadBtn.style.display = 'none';

	console.log('clicked');

	html2canvas(container, {
		backgroundColor: 'white',
		scale: 2,
	}).then((canvas) => {
		downloadBtn.style.display = 'block';
		const link = document.createElement('a');
		link.download = 'ki-wertekompass.png';
		link.href = canvas.toDataURL('image/png');
		link.click();
	});
}
