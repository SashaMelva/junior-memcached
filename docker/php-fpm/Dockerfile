FROM phpdockerio/php74-fpm:latest
WORKDIR "/application"

RUN useradd -ms /bin/bash nonroot

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install php7.4-memcache php7.4-memcached php7.4-sybase php7.4-mysql php7.4-intl mysql-client php7.4-bcmath php7.4-gd nano file wget \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*