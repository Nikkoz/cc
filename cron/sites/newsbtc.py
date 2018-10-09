from .main import Main

class CNewsbtc(Main):
    def __init__(self, link, posts, handbook):
        Main.__init__(self, link, posts, handbook)

        self.menu = [
            'Bitcoin', 'Altcoin',
            'Sponsored', 'ICO', 'Blockchain Projects',
            'Crypto Tech', 'Industry News', 'Press Releases',
        ]

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

        wrapper = soup.find('main', {'id': 'content'})

        try:
            blocks = wrapper.find_all('article')
        except AttributeError:
            raise RuntimeError("structure of the news list has changed1")

        for block in blocks:
            try:
                url = self.check_url(block.find('a', {'class': 'featured-image'}).get('href'))
            except AttributeError:
                raise RuntimeError("structure of the news list has changed")

            date = block.find('span', {'class': 'date'}).text.strip()

            if self.check_date(date, False, "%B %d, %Y") is None:
                break

            try:
                post = self.get_post(url)

                if post['title'] in self.posts:
                    continue

                if post:
                    handbook = self.check_handbook_post(post['title'], post['content'])

                    if handbook:
                        self.result.append({
                            'url': url,
                            'title': post['title'],
                            'date': date,
                            'section': section,
                            'text': post['content'],
                            'handbook': handbook
                        })

                        self.posts.append(post['title'])

            except Warning as error:
                self.log.write("Error: {0}".format(error))

    def get_post(self, url):
        if url is None:
            return

        self.set_file(url)

        soup = self.soup()

        content = soup.find('article')#, {'class': 'post'}

        if content is None:
            raise Warning("structure of the news post has changed. Post link: {0}".format(url))

        title = soup.find('h1', {'class': 'title'})

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
            'title': title.text.strip()
        }