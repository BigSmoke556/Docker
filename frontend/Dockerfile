FROM node:16-bullseye

WORKDIR /app

COPY package*.json ./
RUN npm ci || npm install

RUN mkdir node_modules/.cache && chmod -R 777 node_modules/.cache

COPY . .

ENV HOST=0.0.0.0
EXPOSE 8080

# se node_modules sumir por causa do bind, instala e sobe
CMD sh -c "if [ ! -d node_modules ]; then npm ci || npm install; fi && npm run serve"