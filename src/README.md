# Laravel Product Management Application

## Coding Principles/Practices Applied

1. **SOLID Principles**
   - Single Responsibility Principle (each class has a single responsibility)
   - Open/Closed Principle (classes are open for extension but closed for modification)
   - Liskov Substitution Principle (child classes can substitute parent classes)
   - Interface Segregation Principle (specific interfaces rather than one general-purpose)
   - Dependency Inversion Principle (depend on abstractions, not concretions)

2. **DRY (Don't Repeat Yourself)**
   - Reusable components and traits
   - Centralized validation logic

3. **Repository Pattern**
   - Used for abstracting database operations

4. **Service Layer**
   - Business logic separated from controllers

5. **Dependency Injection**
   - Used throughout the application for better testability

6. **PSR Standards**
   - Followed PSR-1, PSR-2, and PSR-4 coding standards

7. **RESTful Design**
   - Proper resource naming and HTTP verb usage

8. **Validation Separation**
   - Form request validation classes

9. **Middleware for Cross-cutting Concerns**
   - Authentication, authorization, and logging

10. **Testing**
    - Unit tests, feature tests, and integration tests




## API Documentation

To interact with the API, you can import the Postman collection:

- [Download the Postman Collection (api-collection.json)](path/to/api-collection.json)

Or import it into Postman:
1. Open Postman.
2. Click on the `Import` button.
3. Choose the `File` tab and select the `api-collection.json` file you just downloaded.
4. The collection will be imported and you can start using the API requests.

### Example API Calls
Below are the example API endpoints you can test:

- **POST /api/register**: Create new user.
- **POST /api/login**: login user.
- **GET /api/product_list**: Products list.
- **GET /admin/users-with-products**: Show users with proiducts belong to them.
- **PUT /api/products/{id}/details**: SHow product details.
- **GET /api/my-products**: Fetches a of user's list of products and details of the user.
- **POST /api/external-products/add**: Creates a new product.
