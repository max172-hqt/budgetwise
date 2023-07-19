# Introduction

## Database Design

### Tables
- users: User information and credentials, used for authentication
  - name
  - email
  - password
- trips: Trip expenses
  - name
- transaction
  - name
  - amount
  - currency

### Relationships
- One user can belong to many trips
- One trip can have many users
- One trip can have many transactions
- One transaction belongs to one user