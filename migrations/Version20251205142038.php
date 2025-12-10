<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251205142038 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cliente (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(255) DEFAULT NULL, apellido VARCHAR(255) DEFAULT NULL, tipo_documento VARCHAR(255) DEFAULT NULL, numero_documento VARCHAR(255) DEFAULT NULL, correo VARCHAR(255) DEFAULT NULL, celular VARCHAR(20) DEFAULT NULL, direccion VARCHAR(255) DEFAULT NULL, foto_perfil VARCHAR(255) DEFAULT NULL, fecha_registro DATETIME DEFAULT NULL, estado VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TABLE notificacion (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, tipo VARCHAR(255) DEFAULT NULL, titulo VARCHAR(255) DEFAULT NULL, mensaje CLOB DEFAULT NULL, enviado_por VARCHAR(255) DEFAULT NULL, fecha_creacion DATETIME DEFAULT NULL, cliente_id INTEGER DEFAULT NULL, CONSTRAINT FK_729A19ECDE734E51 FOREIGN KEY (cliente_id) REFERENCES cliente (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_729A19ECDE734E51 ON notificacion (cliente_id)');
        $this->addSql('CREATE TABLE pago (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, monto DOUBLE PRECISION DEFAULT NULL, metodo_pago VARCHAR(255) DEFAULT NULL, fecha_pago DATETIME DEFAULT NULL, estado VARCHAR(255) DEFAULT NULL, descripcion CLOB DEFAULT NULL)');
        $this->addSql('CREATE TABLE "plan" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(255) DEFAULT NULL, descripcion CLOB NOT NULL, velocidad_mbps INTEGER DEFAULT NULL, precio_regular DOUBLE PRECISION DEFAULT NULL, precio_promocional DOUBLE PRECISION DEFAULT NULL, porcentaje_descuento INTEGER DEFAULT NULL, caracteristicas CLOB NOT NULL, activo BOOLEAN DEFAULT NULL)');
        $this->addSql('CREATE TABLE servicio (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, direccion_instalacion CLOB DEFAULT NULL, numero_contrato VARCHAR(255) DEFAULT NULL, fecha_instalacion DATETIME DEFAULT NULL, estado VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TABLE solicitud (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, tipo VARCHAR(255) DEFAULT NULL, asunto VARCHAR(255) DEFAULT NULL, descripcion CLOB DEFAULT NULL, prioridad VARCHAR(255) DEFAULT NULL, notas_resolucion CLOB DEFAULT NULL, fecha_creacion DATETIME DEFAULT NULL, fecha_actualizacion DATETIME DEFAULT NULL, fecha_cierre DATETIME DEFAULT NULL)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles CLOB NOT NULL, password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME ON user (username)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE cliente');
        $this->addSql('DROP TABLE notificacion');
        $this->addSql('DROP TABLE pago');
        $this->addSql('DROP TABLE "plan"');
        $this->addSql('DROP TABLE servicio');
        $this->addSql('DROP TABLE solicitud');
        $this->addSql('DROP TABLE user');
    }
}
