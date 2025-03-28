#!/usr/bin/perl

print "Content-type: text/html\n\n";

# modules
use Image::Magick;

# variables
my($image, $x);
$image = Image::Magick->new; 

#set variables
$inpath = $ENV{'REQUEST_URI'};
@getvar = split(/\//, $inpath);
$changePath = @getvar[6];
$changePath=~s(\|)<\/>g;
$wResize = @getvar[3];
$hResize = @getvar[4];
$imagePath = $ENV{'DOCUMENT_ROOT'}.'/images/'.$changePath.'/'; #local
$resizePath = $imagePath;
$imageName = @getvar[7];

$x = $image->Read($imagePath.$imageName); 
($wImage,$hImage)=$image->Get('base-columns','base-rows');

if($hImage >= $wImage)
{
	$wResize = int(($wImage/$hImage)*$hResize); 
}
if($hImage < $wImage)
{
	$hResize = int(($hImage/$wImage)*$wResize); 
}
$image->Resize(geometry=>geometry, width=>$wResize, height=>$hResize); 
#$image->Set(quality=>@getvar[5]);

#write image file
$x = $image->Write($resizePath.$imageName);

#print to browser
#print "Content-type: image/jpg\n\n";
#binmode STDOUT;
#print $image->Write('jpg:-');
