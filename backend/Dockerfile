ARG PHP_VERSION=7.4
FROM php:${PHP_VERSION}-cli

# ------------------------------------------------------------------
# PASSO 1: Instalar dependências, incluindo o dos2unix
# O dos2unix é a ferramenta que irá corrigir as quebras de linha
# ------------------------------------------------------------------
RUN apt-get update && apt-get install -y --no-install-recommends \
    git unzip curl dos2unix \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql bcmath

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html

COPY composer.json composer.lock* ./
RUN mkdir -p /var/www/html && composer install --no-scripts --no-dev --prefer-dist || true

# ------------------------------------------------------------------
# PASSO 2: Copiar, Converter e dar Permissão
# O dos2unix /remove/ o \r E o BOM do script!
# ------------------------------------------------------------------
COPY entrypoint.sh /usr/local/bin/entrypoint.sh

# AQUI: Aplica o dos2unix para garantir a remoção de CRLF (\r) e BOM.
RUN dos2unix /usr/local/bin/entrypoint.sh

RUN chmod +x /usr/local/bin/entrypoint.sh
# ------------------------------------------------------------------


EXPOSE 8000

ENTRYPOINT [ "/usr/local/bin/entrypoint.sh" ]