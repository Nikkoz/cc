from .main import Main

class CLivebitcoinnews(Main):
    def __init__(self, link, posts, handbook):
        Main.__init__(self, link, posts, handbook)

        self.menu = ['Altcoin News', 'Bitcoin News', 'Dogecoin News', 'Litecoin News']

        self.result = []

    def start(self):
        try:
            menu = self.get_menu('id', 'header-nav', 'nav')

            for page in menu:
                self.get_news(page['url'], page['title'])

            self.log.write("End: added {0} posts".format(len(self.result)))
        except RuntimeError as error:
            self.log.write("Error: {0}".format(error))

    def get_news(self, url, section):
        self.set_file(url)

        soup = self.soup()

        slides = soup.find('ul', {'class': 'slides'})
        category = soup.find('div', {'class': 'category-content'})

        try:
            blocks = slides.find_all('div', {'class': 'content'})
        except AttributeError:
            raise RuntimeError("structure of the news list has changed")

        try:
            posts = category.find_all('article', {'class': 'post'})
        except AttributeError:
            raise RuntimeError("structure of the news list has changed")

        blocks = blocks + posts

        if not (blocks):
            raise RuntimeError("structure of the news list has changed")

        for block in blocks:
            h2 = block.find('h2', {'class': 'title'})

            try:
                h = h2
                #a = h.find('a', {'class': 'animsition-link'})
            except AttributeError:
                h = block.find('h3', {'class': 'title'})

            try:
                a = h.find('a')
            except AttributeError:
                raise RuntimeError("structure of the news list has changed")

            url = self.check_url(a.get('href'))
            title = a.text.strip()

            if title in self.posts:
                continue

            try:
                post = self.get_post(url)

                if post:
                    if self.check_date(post['date'], False, '%B %d, %Y') is None:
                        break

                    handbook = self.check_handbook_post(title, post['content'])

                    if handbook:
                        self.result.append({
                            'url': url,
                            'title': title,
                            'date': post['date'],
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

        content = soup.find('div', {'class': 'post-content'})
        date = soup.find('span', {'class': 'date'})

        if content is None or date is None:
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
            'date': date.text.strip()
        }