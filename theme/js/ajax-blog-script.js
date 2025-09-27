document.addEventListener('DOMContentLoaded', function () {
	let filterButtons = document.querySelectorAll('.filter-button');
	let searchText = document.getElementById('text-search-input');
	let paginationContainer = document.getElementById('pagination-container');

	// Check for author parameter in the URL
	const urlParams = new URLSearchParams(window.location.search);
	const authorParam = urlParams.get('author_id'); // Adjust the parameter name if necessary
	const categoryParam = urlParams.get('category_id'); // Adjust the parameter name if necessary

	// Global State
	let currentState = {
		categories: [],
		authors: [],
		search: '',
		paged: 1,
	};

	// Update Global State Function
	function updateState(newData) {
		currentState = { ...currentState, ...newData };
	}

	function fetchFilteredPosts() {
		// Use AJAX to send current state data to our PHP function
		jQuery.ajax({
			type: 'POST',
			url: my_ajax_object.ajax_url,
			data: {
				action: 'fetch_filtered_posts',
				...currentState,
			},
			dataType: 'json',
			success: function (response) {
				let postsContainer = document.getElementById('posts-container');

				if (postsContainer) {
					postsContainer.innerHTML = response.content;
				}
				if (paginationContainer) {
					paginationContainer.innerHTML = response.pagination;
				}

				// Re-attach click event to new pagination links after each AJAX call
				attachPaginationEvents();
			},
		});
	}

	function attachPaginationEvents() {
		if (!paginationContainer) return;
		let paginationLinks = paginationContainer.querySelectorAll('a');
		paginationLinks.forEach((link) => {
			link.addEventListener('click', function (event) {
				event.preventDefault();
				let pageNumber = parseInt(
					new URL(link.href).searchParams.get('paged')
				);
				updateState({ paged: pageNumber });
				fetchFilteredPosts();
			});
		});
	}

	filterButtons.forEach((button) => {
		button.addEventListener('click', function () {
			if (this.classList.contains('active')) {
				this.classList.remove('active');
				this.classList.remove('border-d64blue-900');
				this.classList.add('border-white');
				this.setAttribute('aria-pressed', 'false');
			} else {
				this.classList.add('active');
				this.classList.add('border-d64blue-900');
				this.classList.remove('border-white');
				this.setAttribute('aria-pressed', 'true');
			}

			// Update global state and reset pagination
			let selectedCategories = currentState.categories;
			let selectedAuthors = currentState.authors;
			if (button.getAttribute('data-filter-type') === 'category') {
				let catIndex = selectedCategories.indexOf(
					button.getAttribute('data-id')
				);
				if (catIndex > -1) {
					selectedCategories.splice(catIndex, 1);
				} else {
					selectedCategories.push(button.getAttribute('data-id'));
				}
			} else if (button.getAttribute('data-filter-type') === 'author') {
				let authIndex = selectedAuthors.indexOf(
					button.getAttribute('data-id')
				);
				if (authIndex > -1) {
					selectedAuthors.splice(authIndex, 1);
				} else {
					selectedAuthors.push(button.getAttribute('data-id'));
				}
			}
			updateState({
				categories: selectedCategories,
				authors: selectedAuthors,
				paged: 1, // Reset to the first page whenever filters change
			});
			fetchFilteredPosts();
		});
	});

	// Handle search input
	if (searchText) {
		searchText.addEventListener('input', () => {
			setTimeout(() => {
				updateState({ search: searchText.value, paged: 1 });
				fetchFilteredPosts();
			}, 1000);
		});
	}

	if (authorParam || categoryParam) {
		// console.log(categoryParam);
		// Update the state with the author parameter
		updateState({
			authors: authorParam ? [authorParam] : [],
			categories: categoryParam ? [categoryParam] : [],
			paged: 1,
		});
		fetchFilteredPosts();

		let activeButtonIds = [];
		activeButtonIds.push(
			authorParam && authorParam,
			categoryParam && categoryParam
		);
		highlightButton(activeButtonIds);
	} else {
		// Load posts normally if no author parameter is present
		fetchFilteredPosts();
	}
	attachPaginationEvents();
});

function highlightButton(ids) {
	for (let id of ids) {
		let button = document.querySelector(`[data-id="${id}"]`);
		if (button) {
			button.classList.add('active');
			button.classList.add('border-d64blue-900');
			button.classList.remove('border-white');
			button.setAttribute('aria-pressed', 'true');
		}
	}
}
