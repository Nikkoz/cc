from .main import Main

class CThemerkle(Main):
    def __init__(self, link, posts, handbook):
        Main.__init__(self, link, posts, handbook)

        self.menu = ['News']

        self.result = []

    def start(self):
        try:
            menu = self.get_menu('id', 'menu-menu-2-1')

            for page in menu:
                self.get_news(page['url'], page['title'])

            self.log.write("End: added {0} posts".format(len(self.result)))
        except RuntimeError as error:
            self.log.write("Error: {0}".format(error))

    def get_news(self, url, section):
        self.set_file(url)

        soup = self.soup()

        big_wrapper = soup.find('div', {'class': 'td-big-grid-wrapper'})
        content = soup.find('div', {'class': 'td-ss-main-content'})

        try:
            blocks = big_wrapper.find_all('div', {'class': 'td-big-grid-post'})
        except AttributeError:
            raise RuntimeError("structure of the news list has changed")

        try:
            posts = content.find_all('div', {'class': 'td-block-span6'})
        except AttributeError:
            raise RuntimeError("structure of the news list has changed")

        blocks = blocks + posts

        if not (blocks):
            raise RuntimeError("structure of the news list has changed")

        for block in blocks:
            a = block.find('a', {'class': 'td-image-wrap'})

            url = self.check_url(a.get('href'))
            title = a.get('title').strip()
            date = block.find('time',{'class': 'entry-date'}).get('datetime')

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

        content = soup.find('div', {'class': 'td-post-content'})

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