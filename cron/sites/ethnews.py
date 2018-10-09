from .main import Main

class CEthnews(Main):
    def __init__(self, link, posts, handbook):
        Main.__init__(self, link, posts, handbook)

        self.result = []

    def start(self):
        try:
            self.get_news(self.link + 'news', 'News')
        except RuntimeError as error:
            self.log.write("Error: {0}".format(error))

        self.log.write("End: added {0} posts".format(len(self.result)))

    def get_news(self, url, section):
        self.set_file(url)

        soup = self.soup()

        primary = soup.find('div', {'class': 'news__top__primary'})

        try:
            url = self.check_url(primary.find('a').get('href'))
            title = primary.find('h4').text.strip()
            date = primary.find('i').get('data-created-short')
        except AttributeError:
            raise RuntimeError("structure of the news list has changed1")

        if not title in self.posts and not self.check_date(date) is None:
            try:
                post = self.get_post(url)

                if post:
                    handbook = self.check_handbook_post(title, post['content'])

                    if handbook:
                        self.result.append({
                            'url': url,
                            'title': title,
                            'date': date,
                            'section': section,
                            'text': post['content'],
                            'handbook': handbook
                        })

                        self.posts.append(title)

            except Warning as error:
                self.log.write("Error: {0}".format(error))

        secondary = soup.find('div', {'class': 'news__top__secondary'})
        content = soup.find('div', {'class': 'news__bottom'})

        try:
            blocks = secondary.find_all('div', {'class': 'article-thumbnail-small'})
        except AttributeError:
            raise RuntimeError("structure of the news list has changed")

        try:
            posts = content.find_all('div', {'class': 'article-thumbnail'})
        except AttributeError:
            raise RuntimeError("structure of the news list has changed")

        blocks = blocks + posts

        if not (blocks):
            raise RuntimeError("structure of the news list has changed")

        for block in blocks:
            h4 = block.find('h4', {'class': 'article-thumbnail-small__info__title'})

            try:
                h = h4
            except AttributeError:
                h = block.find('h2', {'class': 'article-thumbnail__info__title'})

            try:
                a = h.find('a')
            except AttributeError:
                raise RuntimeError("structure of the news list has changed")

            url = self.check_url(a.get('href'))
            title = a.text.strip()
            date = block.find('h6').get('data-created-short')

            if title in self.posts:
                continue

            if self.check_date(date) is None:
                break

            try:
                post = self.get_post(url)

                if post:
                    handbook = self.check_handbook_post(title, post['content'])

                    if handbook:
                        self.result.append({
                            'url': url,
                            'title': title,
                            'date': date,
                            'section': section,
                            'text': post['content'],
                            'handbook': handbook
                        })

                        self.posts.append(title)

            except Warning as error:
                self.log.write("Error: {0}".format(error))

    def get_post(self, url):
        if url is None:
            return

        self.set_file(url)

        soup = self.soup()

        content = soup.find('div', {'class': 'article__content'})

        if content is None:
            raise Warning("structure of the news post has changed. Post link: {0}".format(url))

        text = []
        for div in content.find_all('div'):
            if not div is None:
                div.extract()

        for p in content.find_all('p'):
            script = p.script

            if not script is None:
                script.extract()

            text.append(self.clear(p.text))

        return {
            'content': '<br>'.join(text),
        }