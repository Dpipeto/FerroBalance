# Migraciones de Base de Datos

## Estado Actual (18 de Noviembre 2025)

### ✅ Migraciones Ejecutadas

Las siguientes migraciones han sido ejecutadas exitosamente:

1. **2025_11_18_000004_create_roles_table** - Tabla de roles (Administrador, Cajero, Almacenista, Cliente)
2. **2025_11_18_000005_create_user_roles_table** - Tabla pivote para relación many-to-many entre usuarios y roles
3. **2025_11_18_000006_create_customers_table** - Tabla de clientes
4. **2025_11_18_000007_create_products_table** - Tabla de productos con precios en pesos colombianos
5. **2025_11_18_000008_create_invoices_table** - Tabla de facturas/invoices
6. **2025_11_18_000009_create_invoice_lines_table** - Tabla de líneas de factura
7. **2025_11_18_000010_create_payments_table** - Tabla de pagos

### 📊 Seeders Ejecutados

Los siguientes seeders han sido ejecutados para llenar datos de prueba:

- **RoleSeeder**: Crea 4 roles del sistema
- **UserSeeder**: Crea 5 usuarios de prueba con roles asignados
- **ProductSeeder**: Crea 8 productos con precios en COP
- **CustomerSeeder**: Crea 4 clientes
- **FacturaSeeder**: Crea 5 facturas de ejemplo con líneas de detalle

### 🚀 Para Ejecutar en Producción

```bash
php artisan migrate
php artisan db:seed
```

O para resetear completamente:

```bash
php artisan migrate:fresh --seed
```

### 📝 Notas

- La base de datos está configurada para PostgreSQL
- Las tablas usan identificadores en inglés (Invoices, Customers, Products)
- Los timestamps usan convención Laravel (created_at, updated_at)
- Los precios de productos están en pesos colombianos (COP)
