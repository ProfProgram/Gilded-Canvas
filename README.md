# Gilded-Canvas
A web application implemented as an e-commerce website. The project is based on requirements for a university module project. This is Team 37's interpretation of the requirements.

ASTON SERVER HOSTING STATUS :::: (https://cs2team37.cs2410-web01pvm.aston.ac.uk/) ::: current commit equivalent = Server v5

To run the code locally plesae navigate to the TheGuildedCanvas folder and use the command 'php artisan serve', you can also use 'php artisan migrate:fresh --seed' so long as you have a local phpMyAdmin MySQL databse with the name 'cs2team37_db'. If you run into any DB connection issues trying to run locally, please look to .env within TheGuildedCanvas folder to see if your connection variables are incorrect to your actual database.

update1 : Laravel Framework Update

Laravel was committed to the repo. This came along with empty views files, and updated routes to accommodate the views. An update to the default seeder to input dummy/testing data into the database, as well as migration and model files for the database. For more information about the Laravel framework we have kept the automatic README.md that generates upon creation of a Laravel project.

update2 : Pages

Home: 

	FontEnd:

		Routes are working. NavBar is functional. CSS is inconsistent.
		Search by category or name using search bar or the category select, this will send you to the product page with auto filled filters.

	BackEnd:

		Only backend needed was handling the filter data pass-over from home to product page.

Contact Us:

	FontEnd:

		All working as intended.

	BackEnd:

		Although not really "backend" this page will open the users preferred email app and fill in relevant information. It will not automatically send emails.

About Us:

	FontEnd:

		Has introduction text...

	BackEnd:

		Upon feedback from superiors the Contact / About Us page, which acted as a conjoined twin of the two, was separated into two pages. This is the resulting About Us page. - BackEnd (Lore)

Product: (List)

	FontEnd:
	
		Shows all products in a list. Needs consistent CSS as with the rest of the website. The search functionality works for names and categories, including similarities (as well as partial inputs).
		Search by category or name using search bar or the category select. Clicking on img's will send you to that products dynamic page.


	BackEnd:
	
		Adds to the basket, does so when not logged in (issue), but functions as intended when logged in. 
  
Product: (Individual Dynamic pages)

	FontEnd:
	
		Shows information regarding selected product, allows the users to add more than 1 product to cart. Has review section, showing all reviews for that product. Has a 'Leave a Review' button, sending users to the review page.


	BackEnd:
	
		Adds to the basket, does so when not logged in (issue), but functions as intended when logged in. 

Sign-in:

	FontEnd:

		Works as intended. Takes email and password, verifies, and then returns to home view as a logged-in user. Can confirm login was successful since the navbar changes available links based on the logged-in status.

	BackEnd:
		
 		Could add forgot password functionality -> would require auto mail feature to email in the database based on the name given by user trying to login.

Sign-up:

	FontEnd:
		
 		Saves information to the database if inputted correctly. Needs to show errors better if incorrect. Needs CSS to be consistent with the rest of the website.

	BackEnd:

 		Handles user information SQL injection correctly. 

Review:

	FontEnd:

 		Additions include changing the rating from a number input into a start system. Removing the User_id box in the form to make it work seamlessly in the backend. 

	BackEnd:

		Adds reviews to the database using form data. Automatically takes user_id if a user is logged in, otherwise, it has an error message on the review page. This should redirect to the login page in later commits.
  
Basket:

	FontEnd:

 		Shows all products in the cart table. Allows quantities to be amended, affects the total price (live). Initial quantities are based on database values.
   		Baskets are now tailored to the user's ID.
     		Runs different html if the cart_table has no entries tied to user's user_id, prompts the user to 'continue shopping'.

	BackEnd:

 		Delete removes the cart item that has the same basket ID.
   		Update validates the quantity input to be lower than the stock_level and if so saves to the cart_table.
     		On view, the checkout button will POST the total price to the payment page. (not based off JS but PHP so the live update does not get sent to redirect)

Previous Order:

	FontEnd:

 		Shows Orders of currently logged-in users in order of order ID. Lists all products within an order, their quantity and price as well as the admin that approved the order and the total price of the order. A reorder button is next to each product, which redirects to products/{product_name}. Redirects to the login screen if no user is logged in, giving an accompanying error message.

	BackEnd:

		No backend needed, other than the database query for data to be sent to page view.

Payment:

	FontEnd:

 		Works for user_id 1 (currently hard coded), must be made dynamic based on the current user_id. ERROR when being passed the total price from the basket. When the total price is functioning as expected remove the table. CSS is abominable and needs to be made consistent with the rest of the website.

	BackEnd:

		Completing a payment must update the database to have all cart items associated with the current user made into an order and then removed from the cart table. The shipping information can stay as a dummy.

Admin Panel (Inventory Management):

	FontEnd:

 		Shows a table of Product Name, Stock Level, and Actions. Update button is part of Stock Level column and Actions currently only holds the delete button.

	BackEnd:

		Only accessible by Admin users. Currently allows admins to change stock level of products as well as delete them from the database.

Admin Panel (Order Management):

	FontEnd:

 		Shows a table of Orders with column's : 
		Order ID, Customer Name, Product Name, Price per product, Quantity, Total Price, Status, and Actions. Update button is part of Status column and Actions currently only holds the delete button.
		Also has a filer that can filter results by order ID, customer name, or status.

	BackEnd:

		Only accessible by Admin users. Currently allows admins to change status of orders as well as delete them from the database, as well as any cascade deletions in the order_details table.

Manage Users:

	FontEnd:

 		Currently a table of Name, Email, Role, and Actions. Role has the update button to change the role and on page loading will automatically select the role of the user in its row (roles are shown as a select input). Actions column currently only holds the delete button.

	BackEnd:

		Only accessible by Manager users. Currently allows managers to change the role of any person in the users table (allows change between user, admin, manager) - can also remove themselves as a manager. Also allows the deletion of user, admin or manager - sends them to home screen if they delete themselves.
		

update 3 : User Authentication Change

Previous versions used token based managing system. We have changed in this update to a Session system, this allows us to use Auth::user()->user_id to check the user_id of sessions with a log in. We can also check if anyone is signed in using Auth::check(), among other use's.
