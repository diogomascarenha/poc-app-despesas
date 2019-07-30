FROM postgres:11
COPY ./create-extension.sql /docker-entrypoint-initdb.d/create-extension.sql
EXPOSE 5432
CMD ["postgres"]
