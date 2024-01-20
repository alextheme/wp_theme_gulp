import {onWindowResize} from '../utils/index.js';
import {css} from "../utils/functions.js";

const header = () => {
	const getElementHeight = (element, setZeroHeight = true) => {
		element.style.height = 'auto';
		let elementHeight = element.getBoundingClientRect().height;
		element.style.height = setZeroHeight ? 0 : 'unset';
		return elementHeight
	}

	const closeOnClickOutsideElement = (element$, fn = null) => {
		document.addEventListener('click', e => {
			const r = element$.getBoundingClientRect();
            const x = e.clientX;
            const y = e.clientY;

            if (!(x >= r.left && x <= r.right && y >= r.top && y <= r.bottom)) {
				if (fn instanceof Function) {
					fn();
				}
            }
		});
	}

	// Set the height of the site header
	const header$ = document.querySelector('.header');
	onWindowResize(() => {
		document.documentElement.style.setProperty('--height-header', getElementHeight(header$, false) + 'px');
	});

	/** Search Block */
	document.querySelectorAll('.searchTrigger').forEach(button$ => {

		button$.addEventListener('click', () => {
			if (document.body.classList.contains('body--open_search_field')) {
				document.body.classList.remove('body--open_search_field');
			} else {
				document.body.classList.add('body--open_search_field');
			}
		});

		// Close on click outside the Search elemtn
		closeOnClickOutsideElement(document.querySelector('.aws-container'), () => {
			document.body.classList.remove('body--open_search_field');
		});
	});

	/** Menu Trigger */
	const bodyState = 'body--open_menu_state';
	const body$ = document.body;
	const elements$ = document.querySelectorAll('.scrollbarOffset');
	const elements = Array.from(elements$).map(el$ => {
		const value = window.getComputedStyle(el$, null).getPropertyValue('padding-right');
		const match = value.match(/\d+(\.\d+)?/);
		const numericValue = match ? parseFloat(match[0]) : null;
		return [el$, numericValue];
	});

	document.querySelectorAll('.menuTrigger').forEach(menuButton$ => {
		menuButton$.addEventListener('click', () => {
			const innerWidth = window.innerWidth;
			const clientWidth = document.documentElement.clientWidth;

			if (body$.classList.contains(bodyState)) {
				body$.classList.remove(bodyState);
				elements.forEach(el => el[0].style.paddingRight = el[1] + 'px' );
			} else {
				body$.classList.add(bodyState);
				const scrollbarWidth = innerWidth - clientWidth;
				elements.forEach(el => el[0].style.paddingRight = el[1] + scrollbarWidth + 'px' );
			}
		});
	});
};

export default header;
