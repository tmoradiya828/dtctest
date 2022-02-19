# DTC Assement plugin

## Demo live
	URL  : http://test.iso20400plus.com/wp-login.php
	Username : admin@123
	Password : admin123


## Assignment-2a: Simple Alert Plugin  (https://github.com/tmoradiya828/dtctest/tree/main/wp-content/plugins/alert-post-type)

### Admin-Side:
	- Create an admin-side page under settings tab. This page contains following fields those are available with next points. (http://test.iso20400plus.com/wp-content/uploads/2022/02/Screenshot_1.png)
	- Text field for adding text which will be displayed as alert on front side.
	- Checkboxes for all custom post types.
	 For ex:
		 – posts
		 – pages
	- When admin will check any of the above post type’s checkbox, all posts of that post type will be listed below in multi-selectbox. User can select multiple posts from the selection for which they want to show alert on frontend.
	- “Save Changes” button to save your changes. (http://test.iso20400plus.com/wp-content/uploads/2022/02/Screenshot_2.png)
###  Front-end: (http://test.iso20400plus.com/wp-content/uploads/2022/02/Screenshot_3.png)
	- When user will open any page, post or custom post type post and if it is selected from admin side then alert box should be opened.
	- Alert box should contain admin side added text from settings page.




## Assignment-2b: Ticket booking add-on for Contact Form 7 plugin(https://github.com/tmoradiya828/dtctest/tree/main/wp-content/plugins/ticket-booking-addons-for-contact-form-7)

###  Admin-Side:
 	- Add shortcode [ticket_book_cf7] in form before submit button. )(http://test.iso20400plus.com/wp-content/uploads/2022/02/Screenshot_4.png)
###   Front-end: (http://test.iso20400plus.com/index.php/ticket-booking-form/)
	 - At front side, new field with 100 checkboxes should be displayed in contact form.
	 - At first time, all checkboxes should be enabled. User can select any checkboxes from them and submit the form.
	 - Next time, when user come to this page, 100 checkboxes will be displayed, but previously submitted checkboxes should be disabled. So user can’t book those same ticket number again.
