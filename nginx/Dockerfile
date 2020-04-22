FROM nginx:latest

LABEL version="1.0"
LABEL description="laravel"

RUN apt update && \
    apt install -y \
    wget

#entrykit install
RUN wget https://github.com/progrium/entrykit/releases/download/v0.4.0/entrykit_0.4.0_linux_x86_64.tgz && \
    tar -xvzf entrykit_0.4.0_linux_x86_64.tgz && \
    rm entrykit_0.4.0_linux_x86_64.tgz && \
    mv entrykit /usr/local/bin/ && \
    entrykit --symlink 

#entrykit set
RUN rm /etc/nginx/conf.d/*
COPY nginx.conf.tmpl /etc/nginx/
COPY /conf.d/ /etc/nginx/conf.d/

ENTRYPOINT [ \
  "render", \
      "/etc/nginx/nginx.conf", \
      "--", \
  "render", \
      "/etc/nginx/conf.d/upstream.conf", \
      "--", \
  "render", \
      "/etc/nginx/conf.d/public.conf", \
      "--" \
]

CMD ["nginx", "-g", "daemon off;"]
