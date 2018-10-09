from .main import Main

class CCoindesk(Main):
    def __init__(self, link, posts, handbook):
        Main.__init__(self, link, posts, handbook)

        self.menu = [
            'Technology',
            'Markets',
            'Business',
            'Data & Research',
        ]

        self.result = []

    def start(self):
        try:
            menu = self.get_menu('id', 'ubermenu-nav-main-420-mainnav')

            for page in menu:
                self.get_news(page['url'], page['title'])

            self.log.write("End: added {0} posts".format(len(self.result)))
        except RuntimeError as error:
            self.log.write("Error: {0}".format(error))

    def get_news(self, url, section):
        self.set_file(url)

        soup = self.soup()

        wrapper = soup.find('div', {'id': 'content'})

        try:
            blocks = wrapper.find_all('div', {'class': 'article'})
        except AttributeError:
            raise RuntimeError("structure of the news list has changed")

        for block in blocks:
            h3 = block.find('h3')

            try:
                a = h3.find('a')
            except AttributeError:
                raise RuntimeError("structure of the news list has changed")

            url = self.check_url(a.get('href'))
            title = a.get('title').strip()
            date = block.find('time').get('datetime')

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

        content = soup.find('div', {'class': 'article-content-container'})

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