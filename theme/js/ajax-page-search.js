const searchInput = document.getElementById('search');

let totalResults;

searchInput.addEventListener('input', function (e) {
	e.preventDefault();

	const query = e.target.value;

	if (query.length > 2) {
		searchPosts(query);
		// searchPersonen(query);
		searchPages(query);

		let searchResultOverlay = document.getElementById(
			'search-result-overlay'
		);

		if (searchResultOverlay) {
			// show search result overlay
			// delay search result overlay to prevent flickering
			setTimeout(function () {
				searchResultOverlay.classList.remove('hidden');
				searchResultOverlay.classList.add('fixed');
			}, 500);
			// get width of search input
			let searchInputWidth = searchInput.offsetWidth;
			// set width of search result overlay
			searchResultOverlay.style.width = searchInputWidth + 'px';
		}
	}
});

const postsPerPage = 10; // Set as per your requirements

function searchPosts(query, page = 1) {
	fetch(
		`/wp-json/wp/v2/posts?search=${query}&per_page=${postsPerPage}&page=${page}`
	)
		.then((response) => {
			const totalPages = response.headers.get('X-WP-TotalPages');
			displayPagination(totalPages, 'post-pagination', page, (newPage) =>
				searchPosts(query, newPage)
			);
			return response.json();
		})
		.then((data) => {
			displayResults(data, 'post-results');
		});
}

// function searchPersonen(query) {
// 	fetch(`/wp-json/wp/v2/personen?search=${query}`)
// 		.then((response) => response.json())
// 		.then((data) => {
// 			displayResults(data, 'personen-results');
// 		});
// }

function searchPages(query, page = 1) {
	fetch(
		`/wp-json/wp/v2/pages?search=${query}&per_page=${postsPerPage}&page=${page}`
	)
		.then((response) => {
			const totalPages = response.headers.get('X-WP-TotalPages');
			displayPagination(totalPages, 'post-pagination', page, (newPage) =>
				searchPosts(query, newPage)
			);
			return response.json();
		})
		.then((data) => {
			displayResults(data, 'page-results');
		});
}

function displayResults(data, containerId) {
	const container = document.getElementById(containerId);
	container.innerHTML = ''; // Clear any previous results

	if (data.length > 0) {
		container.parentElement.classList.remove('hidden');
		data.forEach((item) => {
			container.innerHTML += `<div class="result-item pb-2">
                <a class=" hover:underline" href="${item.link}">${item.title.rendered}</a>
            </div>`;
		});
	} else {
		// hide parent of container if no results
		container.parentElement.classList.add('hidden');
	}

	// Show no-results div if total results is 0
	const noResults = document.getElementById('no-results');
	if (
		document.getElementById('post-results').childElementCount === 0 &&
		document.getElementById('page-results').childElementCount === 0
	) {
		noResults.classList.remove('hidden');
	} else {
		noResults.classList.add('hidden');
	}
}

function displayPagination(totalPages, containerId, currentPage, callback) {
	const container = document.getElementById(containerId);
	container.innerHTML = '';

	if (totalPages <= 1) {
		document.getElementById(containerId).classList.add('hidden');
	}

	for (let i = 1; i <= totalPages; i++) {
		const pageLink = document.createElement('a');
		pageLink.href = '#';
		pageLink.innerHTML = i;

		if (i === currentPage) {
			pageLink.classList.add('font-bold', 'underline');
		}

		pageLink.addEventListener('click', function (e) {
			e.preventDefault();
			callback(i);
		});
		container.appendChild(pageLink);
	}
}
