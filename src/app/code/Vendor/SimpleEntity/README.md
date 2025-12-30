# Vendor SimpleEntity Module

A simple Magento 2 module that provides CRUD functionality for a basic entity with GraphQL support.

## Features

- **Admin Panel**
  - Admin grid listing with filters and search
  - Create, Edit, Delete functionality
  - Image upload support
  - Status management (Enabled/Disabled)

- **GraphQL API**
  - Get list of entities
  - Get entity by ID
  - Create entity
  - Update entity
  - Delete entity

## Installation

1. Copy the module to `app/code/Vendor/SimpleEntity`
2. Run the following commands:

```bash
bin/magento module:enable Vendor_SimpleEntity
bin/magento setup:upgrade
bin/magento cache:flush
```

## Entity Fields

- `id` (Integer) - Auto-increment primary key
- `name` (String, Required) - Entity name
- `image` (String, Optional) - Image path
- `is_active` (Boolean) - Status (Enabled/Disabled)

## Admin Access

- Menu: **Content > Simple Entity**
- URL: `/admin/simpleentity/entity/index`
- ACL Resource: `Vendor_SimpleEntity::entity`

## GraphQL Queries

### Get All Entities
```graphql
query {
  simpleEntities {
    id
    name
    image
    is_active
  }
}
```

### Get Entity by ID
```graphql
query {
  simpleEntity(id: 1) {
    id
    name
    image
    is_active
  }
}
```

## GraphQL Mutations

### Create Entity
```graphql
mutation {
  createSimpleEntity(
    name: "Test Entity"
    image: "test.jpg"
    is_active: true
  ) {
    id
    name
    image
    is_active
  }
}
```

### Update Entity
```graphql
mutation {
  updateSimpleEntity(
    id: 1
    name: "Updated Name"
    is_active: false
  ) {
    id
    name
    image
    is_active
  }
}
```

### Delete Entity
```graphql
mutation {
  deleteSimpleEntity(id: 1)
}
```

## File Structure

```
app/code/Vendor/SimpleEntity/
├── Block/Adminhtml/Entity/Edit/     # Form buttons
├── Controller/Adminhtml/Entity/    # Admin controllers
├── Model/
│   ├── Entity/                     # Entity model and data provider
│   ├── ResourceModel/              # Resource model and collection
│   └── Resolver/                   # GraphQL resolvers
├── Ui/Component/Listing/Column/     # Grid column components
├── etc/
│   ├── adminhtml/                  # Admin configuration
│   ├── graphql/                    # GraphQL DI
│   ├── acl.xml                     # Access control
│   ├── db_schema.xml               # Database schema
│   ├── di.xml                      # Dependency injection
│   ├── module.xml                  # Module declaration
│   └── schema.graphqls             # GraphQL schema
└── view/adminhtml/
    ├── layout/                     # Layout XML
    └── ui_component/               # UI Component XML
```

