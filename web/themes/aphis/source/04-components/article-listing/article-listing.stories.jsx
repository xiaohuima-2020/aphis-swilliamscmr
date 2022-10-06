import parse from 'html-react-parser';

import twigTemplate from './article-listing.twig';
import data from './article-listing.yml';

const settings = {
  title: 'Components/Article Listing'
};

const ArticleListing = args =>
  parse(
    twigTemplate({
      ...args,
    })
  );
ArticleListing.args = { ...data };

export default settings;
export { ArticleListing };
